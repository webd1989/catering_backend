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
use App\Models\Invoices;
use App\Models\InvoiceItems;
use App\Models\Customers;
use Mpdf\Mpdf;

class InvoicesController extends Controller{

	private static $Users;
	private static $TokenHelper;
	private static $Invoices;
	private static $InvoiceItems;
	private static $Customers;
	private static $LogoController;
	
	public function __construct(){
		self::$Users = new Users();
		self::$TokenHelper = new TokenHelper();
		self::$Invoices = new Invoices();
		self::$InvoiceItems = new InvoiceItems();
		self::$Customers = new Customers();
		self::$LogoController = new LogoController();
	}
	public function updatePayment(Request $request){
		
		self::$Invoices->where('id',$request->id)->update([$request->colum => $request->value]);
		
		$inData = self::$Invoices->where('id',trim($request->id))->first();
		$deduction = $inData->deduction > 0 ? $inData->deduction : 0;
		$tds = $inData->tds_amt > 0 ? $inData->tds_amt : 0;
		$recAmt = $inData->amount - ($deduction+$tds);
		
		self::$Invoices->where('id',$request->id)->update(['rec_amt' => $recAmt]);
		
		return response()->json(['success'=>true, 'message' => 'Invoices updated successfully']);
	}
	public function generatePaymentCSV(Request $request){
		
		$query = self::$Invoices->where('status','!=',3);
		
		if($request->input('is_paid')  && $request->input('is_paid') != ""){
			$query->where('is_paid',$request->input('is_paid')) ;
		}
		if($request->input('bill_no')  && $request->input('bill_no') != ""){
			$query->where('bill_no', 'like', '%'.$request->input('bill_no').'%') ;
		}
		if($request->input('bill_date')  && $request->input('bill_date') != ""){
			$bill_date = date('Y-m-d',strtotime('+1 day', strtotime($request->input('bill_date'))));
			$query->where('bill_date',$bill_date) ;
		}
		if($request->input('rec_date')  && $request->input('rec_date') != ""){
			$bill_date = date('d-m-Y',strtotime('+1 day', strtotime($request->input('rec_date'))));
			$query->where('rec_date',$bill_date) ;
		}
		if($request->input('customer_name')  && $request->input('customer_name') != ""){
			$query->where('customer_name', 'like', '%'.$request->input('customer_name').'%') ;
		}
		if($request->input('customer_gst')  && $request->input('customer_gst') != ""){
			$query->where('customer_gst', 'like', '%'.$request->input('customer_gst').'%') ;
		}
		if($request->input('courier_no')  && $request->input('courier_no') != ""){
			$query->where('courier_no', 'like', '%'.$request->input('courier_no').'%') ;
		}
		if($request->input('amount')  && $request->input('amount') != ""){
			$query->where('amount', 'like', '%'.$request->input('amount').'%') ;
		}
		if($request->input('payment_mode')  && $request->input('payment_mode') != ""){
			$query->where('payment_mode', 'like', '%'.$request->input('payment_mode').'%') ;
		}
		
		$notes = $query->orderBy('id','DESC')->get();
		
		$delimiter = ",";
		$filename = "payments_" . date('d_F_Y') . ".csv";
		
		$destination = "storage/csv/".$filename;
		$f = fopen($destination,"w");
		
		$fields = array(
						'S.NO',
						'STATUS',
						'BILL NO.',
						'BILL DATE',
						'GST CITY/STATE',
						'GST',
						'CO. RECE. NO.',
						'AMOUNT',
						'TDS AMOUNT',
						'PENDING PAYMENT DAYS'
						);
		 
		fputcsv($f, $fields, $delimiter);
		$totalAmount = $tds = 0;
		foreach($notes as $key => $note){
			
			$custData = self::$Customers->where('id',trim($note->customer_id))->first();
			$gstCity = isset($custData->city) ? $custData->city : 'N/A';
			$status = $note->is_paid == 1 ? 'Paid' : 'Unpaid';
			$totalAmount = $totalAmount+$note->amount;
			$tds = $tds+$note->tds_amt;
			
			$noOfDays = 0;
			if($note->bill_date != ''){
				$now = time(); // or your date as well
				$your_date = strtotime($note->bill_date);
				$datediff = $now - $your_date;
				$noOfDays = round($datediff / (60 * 60 * 24));
			}
			
			$lineData = array(
							$key+1,
							$status,
							$note->bill_no,
							date('d-m-Y',strtotime($note->bill_date)),
							$gstCity,
							$note->customer_gst,
							$note->courier_no,
							$note->amount,
							$note->tds_amt,
							$noOfDays
							);
			fputcsv($f, $lineData, $delimiter);
		}
		$lineData3 = array('','','','','','','','','','');						
		fputcsv($f, $lineData3, $delimiter); 
		
		$lineData2 = array('','','','','','','',$totalAmount,$tds,'');						
		fputcsv($f, $lineData2, $delimiter);                     
		
		fclose ($f);

		//move back to beginning of file
		//fseek($f, 0);
		//set headers to download file rather than displayed
		
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header("Cache-Control: max-age=0");		
				

		return response()->json(['success'=>true,'download_url' => env('APP_URL').$destination]);
	}
	public function generatePDF(Request $request){
		
		$html = $this->GetPDFStructure($request->invoice_id);
		$InvoiceDetails = self::$Invoices->where('id', $request->invoice_id)->first();
		
		$fileName = 'invoice_'.$InvoiceDetails->bill_no.'.pdf';
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
		$destination = "storage/pdf/".$fileName;
		
		return response()->json(['success'=>true,'file_name'=>$fileName,'download_url' => env('APP_URL').$destination,'message'=>'Invoice generated successfully'],200);
	}
	public function GetPDFStructure($id){

		$InvoiceDetails = self::$Invoices->where('id', $id)->first();
		$CustomerDetails = self::$Customers->where('id', $InvoiceDetails->customer_id)->first();
		$items = self::$InvoiceItems->where('invoice_id', $id)->get();
		
		if($InvoiceDetails->currency == 'INR'){
			$sign = '₹';
		}else{
			$sign = '$';
		}
		
		$description = "";
		
		$storage_path = storage_path();

		$html = '<table cellspacing="0" width="100%">';
		$html .='<tr><td width="25%"><img width="150" src="'.self::$LogoController->getCoconutLogo().'"></td><td width="75%" style="font-family:tahoma;" colspan="3" ><h1 style="font-size:25px; padding-left:10px;">WEBD IT SOLUTIONS</h1><p style="margin-bottom:20px">Plot No: 62, Moti Nagar, Jhotwara, Jaipur, 302012, India</p><p><b>Deals In:</b> Web Development, Web Design, Web Hosting, Customised Softwares, IOS Application, Android Application, eCommerce Websites, CRM Development</p><p><b>Mobile:</b> +91-7737406899</p><p><b>Email:</b> webddh1989@gmail.com</p></td></tr>';
		
		$html .='<tr><td style="background-color:#000;font-size:5px;" colspan="4">aa</td></tr>';
		
		$html .='<tr><td height="40" style="font-family:tahoma;background-color:#E5E5E5;">&nbsp;&nbsp;<b>Invoice No.:</b> '.$InvoiceDetails->bill_no.' </td><td style="font-family:tahoma;background-color:#E5E5E5;"><b></td><td style="font-family:tahoma;background-color:#E5E5E5;" align="right" colspan="2"><b>Invoice Date:</b> '.date('d/m/Y',$InvoiceDetails->bill_date).'&nbsp;&nbsp;</td></tr>';
		
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
		
		$gstNo = '';
		if($CustomerDetails->gst_no != ''){$gstNo = '<br>&nbsp;&nbsp;GST No: '.$CustomerDetails->gst_no;}
		
		$phone = '';
		if($CustomerDetails->phone != ''){$phone = '<br>&nbsp;&nbsp;Mobile: '.$CustomerDetails->phone;}
		
		$address = '';
		if($CustomerDetails->address != ''){$address = '<br>&nbsp;&nbsp;Address: '.$CustomerDetails->address;}
		
		
		$html .='<tr><td colspan="4" height="80" valign="top" style="font-family:tahoma;">&nbsp;&nbsp;<b>BILL TO</b><br>&nbsp;&nbsp;'.ucwords($CustomerDetails->company).$phone.$address.$gstNo.'</td></tr>';
		
		$html .='<tr><td colspan="4" ><table width="100%" cellspacing="0" >';
		
		
		
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
		$html .='<tr><td style="background-color:#000;" colspan="4"></td></tr>';
		//$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
		
		$html .='<tr><td style="font-family:tahoma;border-left:2px solid #000;padding:5px">&nbsp;&nbsp;ITEMS</td><td style="font-family:tahoma;border-left:2px solid #000;" alight="center">&nbsp;&nbsp;QTY.</td><td style="font-family:tahoma;border-left:2px solid #000;" alight="center">&nbsp;&nbsp;HSN</td><td align="right" style="font-family:tahoma;border-left:2px solid #000;border-right:2px solid #000;">&nbsp;&nbsp;AMOUNT&nbsp;&nbsp;</td></tr>';
		
		//$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
		
		$html .='<tr><td style="background-color:#000;" colspan="4"></td></tr>';
		//$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
		
		$counter = 0;
		foreach($items as $key => $item){
			$html .='<tr>';
			$html .='<td style="font-family:tahoma;border-left:1px solid #000;padding:7px">&nbsp;&nbsp;'.$item->item.'</td>';
			$html .='<td style="font-family:tahoma;border-left:1px solid #000;">&nbsp;&nbsp;'.$item->qty.'</td>';
			$html .='<td style="font-family:tahoma;border-left:1px solid #000;">&nbsp;&nbsp;--</td>';
			$html .='<td align="right" style="font-family:tahoma;border-left:1px solid #000;border-right:1px solid #000;">&nbsp;&nbsp;'.$sign.number_format($item->price).'&nbsp;&nbsp;</td>';
			$html .='</tr>';
			$counter++;
		}
		$t = 25 - $counter;
		for($i=1; $i<=$t; $i++){
			$html .='<tr>';
			$html .='<td style="font-family:tahoma;border-left:1px solid #000;padding:7px"></td>';
			$html .='<td style="font-family:tahoma;border-left:1px solid #000;"></td>';
			$html .='<td style="font-family:tahoma;border-left:1px solid #000;"></td>';
			$html .='<td align="right" style="font-family:tahoma;border-left:1px solid #000;border-right:1px solid #000;"></td>';
			$html .='</tr>';
		}
		
		$html .='</table></td></tr>';
		
		
		//$html .='<tr><td style="height:100px;" colspan="4"></td></tr>';
		
		$html .='<tr><td style="background-color:#000;" colspan="4"></td></tr>';
		//$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
		
		$html .='<tr><td style="font-family:tahoma;border-left:1px solid #000;padding:7px">&nbsp;&nbsp;SUBTOTAL </td><td></td><td ></td><td style="font-family:tahoma;border-right:1px solid #000;" align="right">&nbsp;&nbsp;'.$sign.number_format($InvoiceDetails->amount).'&nbsp;&nbsp;</td></tr>';
		
		//$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
		$html .='<tr><td style="background-color:#000;" colspan="4"></td></tr>';
		
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
		$remaining = $InvoiceDetails->amount-$InvoiceDetails->advance;
		$html .='<tr><td colspan="2" width="50%" style="font-family:tahoma;">&nbsp;&nbsp;<b>BANK DETAILS</b><br>&nbsp;&nbsp;Name: Narendra Jangid <br>&nbsp;&nbsp;IFSC Code: HDFC0000554<br>&nbsp;&nbsp;Account No: 50200075080309<br>&nbsp;&nbsp;Bank: HDFC Bank<br><br>&nbsp;&nbsp;<b>UPI ID: </b> nitam19893@ybl</td><td style="font-family:tahoma;">TOTAL AMOUNT<br><br> ADVANCE AMOUNT<br><br><strong>GRAND TOTAL AMOUNT</strong></td><td style="font-family:tahoma;" align="right">'.$sign.number_format($InvoiceDetails->amount).'&nbsp;&nbsp;<br><br>-'.$sign.number_format($InvoiceDetails->advance).'&nbsp;&nbsp;<br><br><strong>'.$sign.number_format($remaining).'&nbsp;&nbsp;</strong></td></tr>';
		
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
		
		$html .='<tr><td  style="font-family:tahoma;" colspan="4">&nbsp;&nbsp;<b>Total Amount (in words): </b>'.$this->convert_in_words($remaining).'&nbsp;&nbsp;</td></tr>';
		
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" height="30" colspan="4">aa</td></tr>';
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" height="30" colspan="4">aa</td></tr>';
		//$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" height="30" colspan="4">aa</td></tr>';
		//$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" height="30" colspan="4">aa</td></tr>';
		//$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" height="30" colspan="4">aa</td></tr>';
		
		//$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
		$html .='<tr><td style="background-color:#E5E5E5;" colspan="4"></td></tr>';
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
	$html .='<tr><td colspan="4" style="font-family:tahoma;" align="center"><b>Thank You For Your Business!</b></td></tr>';
		
			$html .= '</table>';
		return $html;
	}
	public function convert_in_words($number){
		
		$no = round($number);
		$point = round($number - $no, 2) * 100;
		$hundred = null;
		$digits_1 = strlen($no);
		$i = 0;
		$str = array();
		$words = array('0' => '', '1' => 'one', '2' => 'two',
		 '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
		 '7' => 'seven', '8' => 'eight', '9' => 'nine',
		 '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
		 '13' => 'thirteen', '14' => 'fourteen',
		 '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
		 '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
		 '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
		 '60' => 'sixty', '70' => 'seventy',
		 '80' => 'eighty', '90' => 'ninety');

		$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		while ($i < $digits_1) {

		  $divider = ($i == 2) ? 10 : 100;
		  $number = floor($no % $divider);
		  $no = floor($no / $divider);
		  $i += ($divider == 10) ? 1 : 2;

		  if ($number) {
			 $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
			 $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
			 $str [] = ($number < 21) ? $words[$number] .
				 " " . $digits[$counter] . $plural . " " . $hundred
				 :
				 $words[floor($number / 10) * 10]
				 . " " . $words[$number % 10] . " "
				 . $digits[$counter] . $plural . " " . $hundred;
		  } else $str[] = null;
	   }
	   $str = array_reverse($str);
	   $result = implode('', $str);
	   $points = ($point) ?
		 "." . $words[$point / 10] . " " .
			   $words[$point = $point % 10] : '';
		 //$result . "Rupees  " . $points . " Paise";
	   return ucwords($result);
 	}
	public function getList(Request $request){
		$query = self::$Invoices->where('status','!=',3);
		
		/*if($request->input('search_key')  && $request->input('search_key') != ""){
            $SearchKeyword = $request->input('search_key');
            $query->where(function($query) use ($SearchKeyword)  {
                if(!empty($SearchKeyword)) {
                    $query->where('customer_name', 'like', '%'.$SearchKeyword.'%') 
                    ->orWhere('customer_gst', 'like', '%'.$SearchKeyword.'%')
					->ref_no('customer_gst', 'like', '%'.$SearchKeyword.'%')
					->amount('customer_gst', 'like', '%'.$SearchKeyword.'%')
                    ->orWhere('bill_no', 'like', '%'.$SearchKeyword.'%');
                }
             });
		}*/
		
		if($request->input('invoive_status')  && $request->input('invoive_status') != ""){
			$query->where('status',$request->input('invoive_status')) ;
		}
		if($request->input('bill_no')  && $request->input('bill_no') != ""){
			$query->where('bill_no', 'like', '%'.$request->input('bill_no').'%') ;
		}
		if($request->input('bill_date')  && $request->input('bill_date') != ""){
			$bill_date = date('Y-m-d',strtotime('+1 day', strtotime($request->input('bill_date'))));
			$query->where('bill_date',$bill_date) ;
		}
		if($request->input('rec_date')  && $request->input('rec_date') != ""){
			$bill_date = date('d-m-Y',strtotime('+1 day', strtotime($request->input('rec_date'))));
			$query->where('rec_date',$bill_date) ;
		}
		if($request->input('customer_name')  && $request->input('customer_name') != ""){
			$query->where('customer_id', $request->input('customer_name')) ;
		}
		
		
		$notes = $query->orderBy('bill_no','desc')->paginate(50);
		
		foreach($notes as $key => $note){
			$custData = self::$Customers->where('id',trim($note->customer_id))->first();
			$note->company = strlen($custData->company) > 20 ? substr($custData->company,0,20).'...' : $custData->company;
			$note->company_full = $custData->company;
			$note->cust_data = $custData;
			$note->display_date = date('d M Y',strtotime($note->created_at));
			$note->display_date2 = date('d M Y',$note->bill_date);
			
			if($note->currency == 'INR'){
				$note->amount = '₹ '.number_format($note->amount);
				$note->advance = '₹ '.number_format($note->advance);
				$note->total_amount = '₹ '.number_format($note->total_amount);
			}else{
				$note->amount = '$ '.number_format($note->amount);
				$note->advance = '$ '.number_format($note->advance);
				$note->total_amount = '$ '.number_format($note->total_amount);
			}
			
			if($note->is_paid == 1){
				$note->row_style = 'background-color:#0B32F3 !important; color:#fff;';
			}else{
				$note->row_style = '';
			}
		}
		
		$paidAmount = self::$Invoices->where('status',1)->where('currency','INR')->sum('total_amount');
		$remainigAmount = self::$Invoices->where('status',2)->where('currency','INR')->sum('total_amount');
		$totalAmount = self::$Invoices->where('status','!=',3)->where('currency','INR')->sum('total_amount');
		
		return response()->json(['success'=>true,'totalAmount' => number_format($totalAmount), 'remainigAmount' => number_format($remainigAmount),'paidAmount' => number_format($paidAmount), 'users'=>$notes],200);
	}
	public function getInvoiceCustomers(Request $request){
		$customers = self::$Invoices->select('customer_name')->where('status','!=',3)->orderBy('customer_name','ASC')->groupBy('customer_name')->get();
		return response()->json(['success'=>true,'customers' => $customers],200);
	}
	public function getInvoice(Request $request){
		$invoiceData = self::$Invoices->where('id',$request->id)->first();
		$invoiceData->bill_date = date('d-m-Y',$invoiceData->bill_date);
		$invoiceData->items = self::$InvoiceItems->select(['id','item','qty','hsn','price'])->where('invoice_id',$request->id)->get();
		return response()->json(['success'=>true,'invoiceData' => $invoiceData],200);
	}
	public function AddInvoiceItem(Request $request){
		$validator = Validator::make($request->all(), [
			'id' => 'required|numeric',
			'container_no' => 'required'
			
		],[
			'id.required' => 'Please enter id.',
			'container_no.required' => 'Please enter container no.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('id')){
				return response()->json(['success'=>false, 'message' => $errors->first('id')]);
			}
			if($errors->first('container_no')){
				return response()->json(['success'=>false, 'message' => $errors->first('container_no')]);
			}
		}else{
			$bookingData = self::$Bookings->where('container_no',trim($request->container_no))->first();
			$itemData = self::$InvoiceItems->where('invoice_id',trim($request->id))->first();
			if(isset($bookingData->id)){
				
				$itemExist = self::$InvoiceItems->where('item_id',trim($bookingData->id))->where('status',1)->count();
				if($itemExist > 0){
					return response()->json(['success'=>false, 'message' => 'Container already exist on other invoice']);
				}
				$setData2['added_by'] = $GLOBALS['USER.ID'];
				$setData2['item_id'] = $bookingData->id;
				$setData2['con_no'] = $bookingData->container_no;
				$setData2['size'] = $bookingData->size;
				$setData2['do_date'] = $bookingData->do_date;
				$setData2['from'] = $bookingData->from;
				$setData2['to'] = $bookingData->to;
				$setData2['ref_no'] = $bookingData->shipment_no;
				$setData2['freight'] = $bookingData->l_freight;
				$setData2['vehicle_no'] = $bookingData->vehicle_no;
				$setData2['invoice_id'] = $request->id;
				$setData2['file_name'] = isset($itemData->id) ? $itemData->file_name : '';
				self::$InvoiceItems->create($setData2);
				
				$invoiceData = self::$Invoices->where('id',trim($request->id))->first();
				self::$Bookings->where('id',$bookingData->id)->update(['l_invo_no' => $invoiceData->bill_no,'l_invo_date' => $invoiceData->bill_date]);
				
				$total = 0;
				$allItems = self::$InvoiceItems->where('invoice_id',trim($request->id))->where('status',1)->get();
				foreach($allItems as $key =>$allItem){
					$total = $total+$allItem->freight;
				}
				self::$Invoices->where('id',trim($request->id))->update(['amount' => $total]);
				
				return response()->json(['success'=>true, 'message' => 'Container added successfully']);
				
			}else{
				return response()->json(['success'=>false, 'message' => 'Container does notexist']);
				
			}
		}
	}
	public function createInvoice(Request $request){
		$validator = Validator::make($request->all(), [
			'customer_id' => 'required|numeric',
			'invoice_date' => 'required',
			
		],[
			'customer_id.required' => 'Please select customer.',
			'invoice_date.required' => 'Please enter invoice date.',
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('customer_id')){
				return response()->json(['success'=>false, 'message' => $errors->first('customer_id')]);
			}
			if($errors->first('invoice_date')){
				return response()->json(['success'=>false, 'message' => $errors->first('invoice_date')]);
			}
		}else{
			
			if($request->id > 0){
				$totalPrice = 0;
				$itemIds = [];
				foreach($request->items as $key => $item){
					if($item['item'] !='' && $item['qty'] > 0 && $item['price'] > 0){
						$itemIds[] = $item['id'];
						$totalPrice = $totalPrice+$item['price'];
					}
				}
				if($totalPrice == 0){
					return response()->json(['success'=>false, 'message' => 'Please enter item details']);
				}
				$advance = $request->advance > 0 ? $request->advance : 0;
				$total_amount = $totalPrice - $advance;
				$setData['added_by'] = $GLOBALS['USER.ID'];
				$setData['customer_id'] = $request->customer_id;
				$setData['bill_date'] = strtotime($request->invoice_date);
				$setData['bill_no'] = $request->invoice_no;
				$setData['currency'] = $request->currency;
				$setData['notes'] = $request->notes;
				$setData['amount'] = $totalPrice;
				$setData['total_amount'] = $total_amount;
				$setData['advance'] = $advance;
				$setData['day'] = date('d',strtotime($request->invoice_date));
				$setData['month'] = date('m',strtotime($request->invoice_date));
				$setData['year'] = date('Y',strtotime($request->invoice_date));
				self::$Invoices->where('id',$request->id)->update($setData);
				$allItems = self::$InvoiceItems->where('invoice_id',$request->id)->get();
				foreach($allItems as $key => $allItem){
					if(!in_array($allItem->id,$itemIds)){
						self::$InvoiceItems->where('id',$allItem->id)->delete();
					}
				}
				foreach($request->items as $key => $item){
					if($item['item'] !='' && $item['qty'] > 0){
						
						if($item['id'] > 0){
							$setData2['item'] = $item['item'];
							$setData2['qty'] = $item['qty'];
							$setData2['hsn'] = $item['hsn'];
							$setData2['price'] = $item['price'] > 0 ? $item['price'] : 0;
							self::$InvoiceItems->where('id',$item['id'])->update($setData2);
						}else{
							$setData2['added_by'] = $GLOBALS['USER.ID'];
							$setData2['invoice_id'] = $request->id;
							$setData2['item'] = $item['item'];
							$setData2['qty'] = $item['qty'];
							$setData2['hsn'] = $item['hsn'];
							$setData2['price'] = $item['price'] > 0 ? $item['price'] : 0;
							$setData2['status'] = 1;
							$record = self::$InvoiceItems->create($setData2);
						}
					}
				}
				return response()->json(['success'=>true,'message' => 'Invoice updated successfully']);
				
			}else{
			
				$totalPrice = 0;
				foreach($request->items as $key => $item){
					if($item['item'] !='' && $item['qty'] > 0 && $item['price'] > 0){
						$totalPrice = $totalPrice+$item['price'];
					}
				}
				if($totalPrice == 0){
					return response()->json(['success'=>false, 'message' => 'Please enter item details']);
				}
				$advance = $request->advance > 0 ? $request->advance : 0;
				$total_amount = $totalPrice - $advance;
				$setData['added_by'] = $GLOBALS['USER.ID'];
				$setData['customer_id'] = $request->customer_id;
				$setData['bill_date'] = strtotime($request->invoice_date);
				$setData['bill_no'] = $request->invoice_no;
				$setData['currency'] = $request->currency;
				$setData['notes'] = $request->notes;
				$setData['amount'] = $totalPrice;
				$setData['total_amount'] = $total_amount;
				$setData['advance'] = $advance;
				$setData['day'] = date('d',strtotime($request->invoice_date));
				$setData['month'] = date('m',strtotime($request->invoice_date));
				$setData['year'] = date('Y',strtotime($request->invoice_date));
				$setData['status'] = 2;
				$setData['is_paid'] = 2;
				$invoiceData = self::$Invoices->create($setData);
				
				foreach($request->items as $key => $item){
					if($item['item'] !='' && $item['qty'] > 0){
						$setData2['added_by'] = $GLOBALS['USER.ID'];
						$setData2['invoice_id'] = $invoiceData->id;
						$setData2['item'] = $item['item'];
						$setData2['qty'] = $item['qty'];
						$setData2['hsn'] = $item['hsn'];
						$setData2['price'] = $item['price'] > 0 ? $item['price'] : 0;
						$setData2['status'] = 1;
						$record = self::$InvoiceItems->create($setData2);
					}
				}
				return response()->json(['success'=>true,'message' => 'Invoice created successfully']);
			}
			
		}
	}
	public function billNoGet(Request $request){
		$newBillNo = 100;
		$MaxBillNo = self::$Invoices->max('bill_no');
		if($MaxBillNo > 0){
			$newBillNo = $MaxBillNo+1;
		}
		return response()->json(['success'=>true,'newBillNo'=>$newBillNo,'newBillDate'=>date('d-m-Y')],200);
	}
	public function updateStatus(Request $request,$id,$status){
		$users = self::$Invoices->where('id',$id)->update(['status' => $status]);
		return response()->json(['success'=>true,'message'=>'Record deleted successfully'],200);
	}
	public function generateCsv(Request $request){
		
		$delimiter = ",";
		$filename = "invoices_" . date('d_F_Y') . ".csv";
		
		$destination = "storage/csv/".$filename;
		$f = fopen($destination,"w");
		
		$fields = array(
						'S.NO',
						'BILL No',
						'BILL Date',
						'CUSTOMER NAME',
						'CONT NO.',
						'SIZE',
						'DO DATE',
						'FROM',
						'TO',
						'REF NO.',
						'FREIGHT.',
						);
		 
		fputcsv($f, $fields, $delimiter);
		
		$counter = 1;
		foreach($request->selectedRow as $key => $rowID){
			$invoiceData = self::$Invoices->where('id',$rowID)->first();
			$items = self::$InvoiceItems->where('invoice_id',$invoiceData->id)->where('status',1)->get();
			foreach($items as $key => $item){
				$lineData = array(
								$counter,
								$invoiceData->bill_no,
								$invoiceData->bill_date,
								$invoiceData->customer_name,
								$item->con_no,
								$item->size,
								$item->do_date,
								$item->from,
								$item->to,
								$item->ref_no,
								$item->freight
								);
				fputcsv($f, $lineData, $delimiter);
				$counter++;
			}
		}
		
		$lineData2 = array('','');						
		fputcsv($f, $lineData2, $delimiter);                     
		
		fclose ($f);

		//move back to beginning of file
		//fseek($f, 0);
		//set headers to download file rather than displayed
		
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header("Cache-Control: max-age=0");		
				

		return response()->json(['success'=>true,'download_url' => env('APP_URL').$destination]);
	}
}
