<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LogoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Validation\Rule;
use ReallySimpleJWT\Token;
use App\Models\Users;
use App\Models\Responses;
use Session;
use App\Models\TokenHelper;
use App\Models\Bookings;
use App\Models\BookingEvents;
use App\Models\LogisticRanges;
use App\Models\EventTypes;
use Mpdf\Mpdf;

class BookingController extends Controller{

	private static $Users;
	private static $TokenHelper;
	private static $Bookings;
	private static $LogoController;
	private static $BookingEvents;
	private static $LogisticRanges;
	private static $EventTypes;
	
	public function __construct(){
		self::$Users = new Users();
		self::$TokenHelper = new TokenHelper();
		self::$Bookings = new Bookings();
		self::$LogoController = new LogoController();
		self::$BookingEvents = new BookingEvents();
		self::$LogisticRanges = new LogisticRanges();
		self::$EventTypes = new EventTypes();
		
	}
	public function getData(Request $request){
		$noteData = self::$Bookings->where('id',$request->id)->first();
		$noteData->booked_event_types = self::$BookingEvents->where('booking_id', $request->id)
    ->orderBy('event_date', 'asc')
    ->get()
    ->groupBy('event_date');
		return response()->json(['success'=>true,'user'=>$noteData],200);
	}
	public function getListAll(Request $request){
		$records = self::$Bookings->select('id','booking_title','name','booking_status','location','event_date')->where('status','!=',3)->orderBy('event_date','ASC')->get();
		foreach($records as $key => $record){
			$record->title = $record->booking_title;
			$record->customer_name = $record->name;
			$record->date = $record->event_date;
			$record->start_time = '10:00';
			$record->end_time = '14:00';
			$record->status = $record->booking_status;
			
			unset($record->booking_title);
			unset($record->event_date);
			unset($record->name);
			unset($record->booking_status);
		}
		return response()->json(['success'=>true,'records'=>$records],200);
	}
	public function getSubCateListAll(Request $request){
		$records = self::$Bookings->where('status','!=',3)->orderBy('title','ASC')->get();
		return response()->json(['success'=>true,'records'=>$records],200);
	}
	public function getList(Request $request){
		$query = self::$Bookings->where('status','!=',3);

		if($request->input('title_search')  && $request->input('title_search') != ""){
            $query->where('title', 'like', '%'.$request->input('title_search').'%'); 
		}
		if($request->input('status_search')  && $request->input('status_search') != ""){
            $query->where('status',$request->input('status_search')); 
		}
		if($request->input('booking_status')  && $request->input('booking_status') != ""){
            $query->where('booking_status',$request->input('booking_status')); 
		}
		
		$notes = $query->orderBy('event_date','ASC')->paginate(10);
		
		foreach($notes as $key => $note){

			$note->display_date = date('d F Y',strtotime($note->created_at));
			$note->display_event_date = date('d F Y',strtotime($note->event_date));
			//$note->total = self::$BookingEvents->where('booking_id',$note->id)->sum('total');
		}
		return response()->json(['success'=>true,'users'=>$notes],200);
	}
	public function updateStatus(Request $request,$id,$status){
		$users = self::$Bookings->where('id',$id)->update(['status' => $status]);
		return response()->json(['success'=>true,'message'=>'Record deleted successfully'],200);
	}
	public function create(Request $request){
		$validator = Validator::make($request->all(), [
			'booking_title' => 'required',
			'name' => 'required',
			'phone' => 'required|numeric|digits_between:10,12',
			'event_date' => 'required|date|after_or_equal:today',
			'address' => 'required',
			'location' => 'required',
			'no_of_guest' => 'required|numeric'
			
		],[
			
			'booking_title.required' => 'Please enter booking title.',
			'name.required' => 'Please enter name.',
			'phone.required' => 'Please enter phone.',
			'event_date.required' => 'Please enter event_date.',
			'address.required' => 'Please enter address.',
			'location.required' => 'Please enter location.',
			'no_of_guest.required' => 'Please enter no of guest.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			
			if($errors->first('booking_title')){
				return response()->json(['success'=>false, 'message' => $errors->first('booking_title')]);
			}
			if($errors->first('name')){
				return response()->json(['success'=>false, 'message' => $errors->first('name')]);
			}
			if($errors->first('phone')){
				return response()->json(['success'=>false, 'message' => $errors->first('phone')]);
			}
			if($errors->first('event_date')){
				return response()->json(['success'=>false, 'message' => $errors->first('event_date')]);
			}
			if($errors->first('address')){
				return response()->json(['success'=>false, 'message' => $errors->first('address')]);
			}
			if($errors->first('location')){
				return response()->json(['success'=>false, 'message' => $errors->first('location')]);
			}
			if($errors->first('no_of_guest')){
				return response()->json(['success'=>false, 'message' => $errors->first('no_of_guest')]);
			}
		}else{
			
			$checkExist = self::$Bookings->where('event_date',$request->event_date)->count();
			/*if($checkExist > 0){
				return response()->json(['success'=>false, 'message' => 'Event already exist on '.$request->event_date.' date']);
			}*/
			
			$setData['added_by'] = $GLOBALS['USER.ID'];
			$setData['booking_title'] = $request->booking_title;
			$setData['name'] = $request->name;
			$setData['email'] = $request->email;
			$setData['phone'] = $request->phone;
			$setData['event_date'] = $request->event_date;
			$setData['address'] = $request->address;
			$setData['location'] = $request->location;
			$setData['no_of_guest'] = $request->no_of_guest;
			$setData['advance_amt'] = $request->advance_amt;
			$setData['vehicle_no'] = $request->vehicle_no;
			$setData['deleivery_time'] = $request->deleivery_time;
			$setData['payment_mode'] = $request->payment_mode;
			$setData['advance_date'] = $request->advance_date;
			$setData['payment_info'] = json_encode($request->payment_info);
			$setData['location_url'] = $request->location_url;
			$setData['gst'] = $request->gst;
			$setData['logistic_range'] = $request->logistic_range;
			$setData['booking_status'] = $request->booking_status;
			$record = self::$Bookings->create($setData);
			
			foreach($request->eventTypesRows as $key => $eventTypesRow){
				if($eventTypesRow['event_date'] != ''){
					foreach($eventTypesRow['event_attributes'] as $key => $attributes){
						if($attributes['event_type_id'] > 0 && $attributes['per_person'] > 0 && $attributes['no_of_guest'] > 0){
							$setData2['booking_id'] = $record->id;
							$setData2['event_type_id'] = $attributes['event_type_id'];
							$setData2['rate'] = $attributes['per_person'];
							$setData2['event_date'] = $eventTypesRow['event_date'];
							$setData2['no_of_guest'] = $attributes['no_of_guest'];
							$setData2['event_time'] = $attributes['event_time'];
							$setData2['venue'] = $attributes['venue'];
							$setData2['sub_venue'] = $attributes['sub_venue'];
							$setData2['total'] = $attributes['per_person']*$attributes['no_of_guest'];
							self::$BookingEvents->create($setData2);
						}
					}
				}
			}
			
			$eventTotal = self::$BookingEvents->where('booking_id',$record->id)->sum('total');
			$rangeData = self::$LogisticRanges->where('id',$request->logistic_range)->first();
			$rangeAmt = isset($rangeData->id) ? $rangeData->amount : 0;
			$totalAmt = $eventTotal+$rangeAmt;
			
			$taxAmt = ($totalAmt*$request->gst)/100;
			
			$totalAmt = $eventTotal+$rangeAmt+$taxAmt;
			
			self::$Bookings->where('id',$record->id)->update(['total' => $totalAmt,'logistic' => $rangeAmt,'gst_amt' => $taxAmt]);
			
			return response()->json(['success'=>true, 'message' => 'Record added successfully']);
		}
	}
	public function update(Request $request){
		$validator = Validator::make($request->all(), [
			'booking_title' => 'required',
			'name' => 'required',
			'phone' => 'required|numeric|digits_between:10,12',
			'event_date' => 'required|date|after_or_equal:today',
			'address' => 'required',
			'location' => 'required',
			'no_of_guest' => 'required|numeric'
			
		],[
			
			'booking_title.required' => 'Please enter booking title.',
			'name.required' => 'Please enter name.',
			'phone.required' => 'Please enter phone.',
			'event_date.required' => 'Please enter event_date.',
			'address.required' => 'Please enter address.',
			'location.required' => 'Please enter location.',
			'no_of_guest.required' => 'Please enter no of guest.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('booking_title')){
				return response()->json(['success'=>false, 'message' => $errors->first('booking_title')]);
			}
			if($errors->first('name')){
				return response()->json(['success'=>false, 'message' => $errors->first('name')]);
			}
			if($errors->first('phone')){
				return response()->json(['success'=>false, 'message' => $errors->first('phone')]);
			}
			if($errors->first('event_date')){
				return response()->json(['success'=>false, 'message' => $errors->first('event_date')]);
			}
			if($errors->first('address')){
				return response()->json(['success'=>false, 'message' => $errors->first('address')]);
			}
			if($errors->first('location')){
				return response()->json(['success'=>false, 'message' => $errors->first('location')]);
			}
			if($errors->first('no_of_guest')){
				return response()->json(['success'=>false, 'message' => $errors->first('no_of_guest')]);
			}
		}else{
			$setData['name'] = $request->name;
			$setData['booking_title'] = $request->booking_title;
			$setData['email'] = $request->email;
			$setData['phone'] = $request->phone;
			$setData['event_date'] = $request->event_date;
			$setData['address'] = $request->address;
			$setData['location'] = $request->location;
			$setData['no_of_guest'] = $request->no_of_guest;
			$setData['advance_amt'] = $request->advance_amt;
			$setData['vehicle_no'] = $request->vehicle_no;
			$setData['deleivery_time'] = $request->deleivery_time;
			$setData['payment_mode'] = $request->payment_mode;
			$setData['advance_date'] = $request->advance_date;
			$setData['payment_info'] = json_encode($request->payment_info);
			$setData['location_url'] = $request->location_url;
			$setData['gst'] = $request->gst;
			$setData['logistic_range'] = $request->logistic_range;
			$setData['booking_status'] = $request->booking_status;
				
			self::$Bookings->where('id',$request->id)->update($setData);
			
			foreach($request->eventTypesRows as $key => $eventTypesRow){
				if($eventTypesRow['event_date'] != ''){
					foreach($eventTypesRow['event_attributes'] as $key => $attributes){
						if($attributes['event_type_id'] > 0 && $attributes['per_person'] > 0 && $attributes['no_of_guest'] > 0){
							$setData2['booking_id'] = $request->id;
							$setData2['event_type_id'] = $attributes['event_type_id'];
							$setData2['rate'] = $attributes['per_person'];
							$setData2['event_date'] = $eventTypesRow['event_date'];
							$setData2['no_of_guest'] = $attributes['no_of_guest'];
							$setData2['event_time'] = $attributes['event_time'];
							$setData2['venue'] = $attributes['venue'];
							$setData2['sub_venue'] = $attributes['sub_venue'];
							$setData2['total'] = $attributes['per_person']*$attributes['no_of_guest'];
							if($attributes['id'] > 0){
								self::$BookingEvents->where('id',$attributes['id'])->update($setData2);
							}else{
								self::$BookingEvents->create($setData2);
							}
						}
					}
				}
			}
			
			$eventTotal = self::$BookingEvents->where('booking_id',$request->id)->sum('total');
			$rangeData = self::$LogisticRanges->where('id',$request->logistic_range)->first();
			$rangeAmt = isset($rangeData->id) ? $rangeData->amount : 0;
			$totalAmt = $eventTotal+$rangeAmt;
			
			$taxAmt = ($totalAmt*$request->gst)/100;
			
			$totalAmt = $eventTotal+$rangeAmt+$taxAmt;
			
			self::$Bookings->where('id',$request->id)->update(['total' => $totalAmt,'logistic' => $rangeAmt,'gst_amt' => $taxAmt]);
			
			return response()->json(['success'=>true, 'message' => 'Record updated successfully']);
		}
	}
	public function generatePdf(Request $request){
		$booking = self::$Bookings->where('id',$request->id)->first();
		$bookingEvents = self::$BookingEvents->where('booking_id',$request->id)->orderBy('event_date','ASC')->get();
		$eventDates = self::$BookingEvents->select('event_date')->where('booking_id',$request->id)->distinct()->orderBy('event_date','ASC')->get();
		
		foreach($eventDates as $key => $eventDate){
			$eventDate->formated_date = strtoupper(date('l, jS F Y', strtotime($eventDate->event_date)));
			$eventDate->formated_date_short = strtoupper(date('jS M', strtotime($eventDate->event_date)));
			$bookingEvents = self::$BookingEvents->where('event_date',$eventDate->event_date)->where('booking_id',$request->id)->orderBy('event_date','ASC')->get();
			foreach($bookingEvents as $key2 => $bookingEvent){
				$type = self::$EventTypes->where('id',$bookingEvent->event_type_id)->first();
				$bookingEvent->event_type_title = $type->title;
			}
			$eventDate->events = $bookingEvents;
		}
		
		$booking->formated_events = $eventDates;
		
		//$html = view('pdf.function-details',['booking' => $booking,'bookingEvents' => $bookingEvents])->render();
		$html = '<div style="text-align:center; padding-bottom:8px;">
        <div style="font-size:22px; font-weight:bold; letter-spacing:2px; color:#1a1a1a;"><img src="https://www.mamusinfusion.com/public/img/logo.svg" ></div>
    </div>

    <table style="width:100%; margin-top:6px; font-size:9.5px; color:#555555; border-collapse:collapse;">
        <tr>
            <td style="padding:1px 0;"></td>
            <td style="padding:1px 0; text-align:right;">Date of Issue: <strong>'.$booking->created_at.'</strong></td>
        </tr>
    </table>
	<div style="text-align:center; background:#1a1a1a; color:#ffffff; padding:7px 0; font-size:13px; font-weight:bold; letter-spacing:1px; margin-top:10px;">FUNCTION DETAILS &amp; BOOKING CONFIRMATION</div>
    <div style="text-align:center; font-size:10px; letter-spacing:3px; color:#8a6d3b; padding:5px 0 12px 0; border-bottom:2px solid #8a6d3b; margin-bottom:12px;">WEDDING FUNCTIONS — DECEMBER 2026 — JAIPUR</div>
	 <div style="background:#f2ede3; border-left:4px solid #8a6d3b; padding:5px 8px; font-size:11px; font-weight:bold; letter-spacing:1px; margin:14px 0 6px 0; color:#1a1a1a;">CLIENT &amp; EVENT DETAILS</div>
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; background:#f7f4ee; font-weight:bold; width:16%; color:#444444;">Client Name</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; width:34%;">'.$booking->name.'</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; background:#f7f4ee; font-weight:bold; width:16%; color:#444444;">Contact No.</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; width:34%;">'.$booking->phone.'</td>
        </tr>
        <tr>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; background:#f7f4ee; font-weight:bold; color:#444444;">Event Type</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px;">'.$booking->booking_title.'</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; background:#f7f4ee; font-weight:bold; color:#444444;">Email</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px;">'.$booking->email.'</td>
        </tr>
        <tr>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; background:#f7f4ee; font-weight:bold; color:#444444;">Event Dates</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px;">'.$booking->event_date.'</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; background:#f7f4ee; font-weight:bold; color:#444444;">City</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px;">'.$booking->location.'</td>
        </tr>
        <tr>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; background:#f7f4ee; font-weight:bold; color:#444444;">Venues</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px;">'.$booking->address.'</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; background:#f7f4ee; font-weight:bold; color:#444444;">Total Functions</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px;">'.$bookingEvents->count().' Functions</td>
        </tr>
        <tr>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; background:#f7f4ee; font-weight:bold; color:#444444;">Booking Status</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px;" colspan="3">'.ucwords($booking->booking_status).'</td>
        </tr>
    </table>';
	
	$html .= '<div style="background:#f2ede3; border-left:4px solid #8a6d3b; padding:5px 8px; font-size:11px; font-weight:bold; letter-spacing:1px; margin:14px 0 6px 0; color:#1a1a1a;">FUNCTION SCHEDULE</div>';
	
	foreach($booking->formated_events as $key=> $day){
	
	

    $html .= '<div style="background:#1a1a1a; color:#ffffff; padding:4px 8px; font-size:10px; font-weight:bold; letter-spacing:1px; margin:10px 0 0 0;">'.$day->formated_date.'</div>
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <th style="background:#f7f4ee; border:1px solid #d9d2c3; padding:4px 6px; font-size:9.5px; text-transform:uppercase; letter-spacing:0.5px; text-align:left; color:#444444; width:22%;">Function</th>
            
            <th style="background:#f7f4ee; border:1px solid #d9d2c3; padding:4px 6px; font-size:9.5px; text-transform:uppercase; letter-spacing:0.5px; text-align:center; color:#444444; width:10%;">Rate</th>

            <th style="background:#f7f4ee; border:1px solid #d9d2c3; padding:4px 6px; font-size:9.5px; text-transform:uppercase; letter-spacing:0.5px; text-align:center; color:#444444; width:10%;">No Of Guest</th>
        </tr>';
		
		foreach($day->events as $key=> $single){
		
        $html .= '<tr>
            <td style="border:1px solid #d9d2c3; padding:4px 6px;">'.$single->event_type_title.'</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; text-align:center;">'.$single->rate.' Per Pax</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; text-align:center;">'.$single->no_of_guest.'</td>
        </tr>';
		
		}
        
    $html .= '</table>';
	
	}
	
	$eventTypes = self::$BookingEvents->select('event_type_id')->where('booking_id',$request->id)->distinct()->get();
	
	$html .= '<div style="background:#f2ede3; border-left:4px solid #8a6d3b; padding:5px 8px; font-size:11px; font-weight:bold; letter-spacing:1px; margin:14px 0 6px 0; color:#1a1a1a;">CONSOLIDATED PAX SUMMARY</div>
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <th style="background:#f7f4ee; border:1px solid #d9d2c3; padding:4px 6px; font-size:9.5px; text-transform:uppercase; letter-spacing:0.5px; text-align:left; color:#444444; width:28%;">Function</th>';
			foreach($booking->formated_events as $key=> $day){
            $html .= '<th style="background:#f7f4ee; border:1px solid #d9d2c3; padding:4px 6px; font-size:9.5px; text-transform:uppercase; letter-spacing:0.5px; text-align:center; color:#444444; width:18%;">'.$day->formated_date_short.'</th>';
			}
			
            $html .= '<th style="background:#f7f4ee; border:1px solid #d9d2c3; padding:4px 6px; font-size:9.5px; text-transform:uppercase; letter-spacing:0.5px; text-align:center; color:#444444; width:18%;">Total Pax</th>
        </tr>';
		foreach($eventTypes as $key2 => $eventType){
			$type = self::$EventTypes->where('id',$eventType->event_type_id)->first();
        $html .= '<tr>
            <td style="border:1px solid #d9d2c3; padding:4px 6px;">'.$type->title.'</td>';
			foreach($booking->formated_events as $key=> $day){
				$singlePax = self::$BookingEvents->where('booking_id',$request->id)->where('event_date',$day->event_date)->where('event_type_id',$eventType->event_type_id)->first();
				$nit = isset($singlePax->id) ? $singlePax->no_of_guest : '-';
            $html .= '<td style="border:1px solid #d9d2c3; padding:4px 6px; text-align:center;">'.$nit.'</td>';
			}
			$sGuest = self::$BookingEvents->where('booking_id',$request->id)->where('event_type_id',$eventType->event_type_id)->sum('no_of_guest');
            $html .= '<td style="border:1px solid #d9d2c3; padding:4px 6px; text-align:center;">'.$sGuest.'</td>
        </tr>';
		}
        
        $html .= '<tr>
            <td style="border:1px solid #1a1a1a; padding:4px 6px; background:#1a1a1a; color:#ffffff; font-weight:bold; font-size:11px;">GRAND TOTAL</td>';
			$gt = 0;
			foreach($booking->formated_events as $key=> $day){
				$tGuest = self::$BookingEvents->where('booking_id',$request->id)->where('event_date',$day->event_date)->sum('no_of_guest');
            $html .= '<td style="border:1px solid #1a1a1a; padding:4px 6px; background:#1a1a1a; color:#ffffff; font-weight:bold; font-size:11px; text-align:center;">'.$tGuest.'</td>';
			$gt = $gt+$tGuest;
			}
            $html .= '<td style="border:1px solid #1a1a1a; padding:4px 6px; background:#1a1a1a; color:#ffffff; font-weight:bold; font-size:11px; text-align:center;">'.$gt.' PAX</td>
        </tr>
    </table>

    <div style="page-break-before:always;"></div>
	<div style="background:#f2ede3; border-left:4px solid #8a6d3b; padding:5px 8px; font-size:11px; font-weight:bold; letter-spacing:1px; margin:14px 0 6px 0; color:#1a1a1a;">COMMERCIAL SUMMARY</div>
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <th style="background:#f7f4ee; border:1px solid #d9d2c3; padding:4px 6px; font-size:9.5px; text-transform:uppercase; letter-spacing:0.5px; text-align:left; color:#444444; width:44%;">Particulars</th>
            <th style="background:#f7f4ee; border:1px solid #d9d2c3; padding:4px 6px; font-size:9.5px; text-transform:uppercase; letter-spacing:0.5px; text-align:center; color:#444444; width:14%;">Pax</th>
            <th style="background:#f7f4ee; border:1px solid #d9d2c3; padding:4px 6px; font-size:9.5px; text-transform:uppercase; letter-spacing:0.5px; text-align:center; color:#444444; width:16%;">Rate / Pax</th>
            <th style="background:#f7f4ee; border:1px solid #d9d2c3; padding:4px 6px; font-size:9.5px; text-transform:uppercase; letter-spacing:0.5px; text-align:right; color:#444444; width:26%;">Amount (INR)</th>
        </tr>';
		
		$rangeData = self::$LogisticRanges->where('id',$booking->logistic_range)->first();
		$rangeAmt = isset($rangeData->id) ? $rangeData->amount : 0;
		
		$gsubtotal = 0;	
		foreach($eventTypes as $key2 => $eventType){
			$type = self::$EventTypes->where('id',$eventType->event_type_id)->first();
			$sGuest = self::$BookingEvents->where('booking_id',$request->id)->where('event_type_id',$eventType->event_type_id)->sum('no_of_guest');
			$forRate = self::$BookingEvents->where('booking_id',$request->id)->where('event_type_id',$eventType->event_type_id)->first();
			$subTotal = $forRate->rate*$sGuest;
			$gsubtotal = $gsubtotal+$subTotal;
        $html .= '<tr>
            <td style="border:1px solid #d9d2c3; padding:4px 6px;">'.$type->title.' Counter Service</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; text-align:center;">'.$sGuest.'</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; text-align:center;">'.$forRate->rate.'</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; text-align:right;">'.$subTotal.'</td>
        </tr>';
		}
		$totalAmt = $rangeAmt+$gsubtotal;
        $taxAmt = ($totalAmt*$booking->gst)/100;
        $html .= '<tr>
            <td style="border:1px solid #d9d2c3; padding:4px 6px;">Transportation, Setup &amp; Manpower<br><span style="font-size:8.5px; color:#666666;">3 days • 2 venues</span></td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; text-align:center;">—</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; text-align:center;">Lumpsum</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; text-align:right;">'.$rangeAmt.'</td>
        </tr>
        <tr>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; background:#f2ede3; font-weight:bold;" colspan="3">Sub Total</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; background:#f2ede3; font-weight:bold; text-align:right;">'.($rangeAmt+$gsubtotal).'</td>
        </tr>
        <tr>
            <td style="border:1px solid #d9d2c3; padding:4px 6px;" colspan="3">GST @ '.$booking->gst.'%</td>
            <td style="border:1px solid #d9d2c3; padding:4px 6px; text-align:right;">'.$taxAmt.'</td>
        </tr>
        <tr>
            <td style="border:1px solid #1a1a1a; padding:4px 6px; background:#1a1a1a; color:#ffffff; font-weight:bold; font-size:11px;" colspan="3">TOTAL PAYABLE</td>
            <td style="border:1px solid #1a1a1a; padding:4px 6px; background:#1a1a1a; color:#ffffff; font-weight:bold; font-size:15px; text-align:right;">Rs. '.($rangeAmt+$gsubtotal+$taxAmt).'/-</td>
        </tr>
    </table>
    ';
		
		
		
		//$fileName = 'invoice_'.rand(1001,9999).$request->id.'.pdf';
		$fileName = 'booking_'.$request->id.'.pdf';
		
		
		
		$mypdf = new mPDF([
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 5,
            'margin_bottom' => 5,
            'margin_header' => 1,
            'margin_footer' => 1,
        ]);
		$mypdf->SetDisplayMode('fullpage');
		$mypdf->WriteHTML($html);
		$storage_path = storage_path();
		$structure = $storage_path . "/pdf/";
		$file_name = $structure . $fileName;
		$mypdf->Output($file_name);
		return response()->json(['success'=>true,'file_name'=>$fileName,'booking' => $booking],200);
	}
}
