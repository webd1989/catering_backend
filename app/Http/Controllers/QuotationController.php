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
use App\Models\Quotations;
use Mpdf\Mpdf;

class QuotationController extends Controller{

	private static $Users;
	private static $TokenHelper;
	private static $Quotations;
	private static $LogoController;
	
	public function __construct(){
		self::$Users = new Users();
		self::$TokenHelper = new TokenHelper();
		self::$Quotations = new Quotations();
		self::$LogoController = new LogoController();
		
	}
	public function getData(Request $request){
		$noteData = self::$Quotations->where('id',$request->id)->first();
		return response()->json(['success'=>true,'user'=>$noteData],200);
	}
	public function getListAll(Request $request){
		$notes = self::$Quotations->where('status','!=',3)->orderBy('id','DESC')->get();
		return response()->json(['success'=>true,'targets'=>$notes],200);
	}
	public function getList(Request $request){
		$query = self::$Quotations->where('status','!=',3);
		
		if($request->input('title_search')  && $request->input('title_search') != ""){
            $query->where('title', 'like', '%'.$request->input('title_search').'%'); 
		}
		if($request->input('status_search')  && $request->input('status_search') != ""){
            $query->where('status',$request->input('status_search')); 
		}
		
		$notes = $query->orderBy('id','DESC')->paginate(10);
		
		foreach($notes as $key => $note){

			$note->display_date = date('d F Y',strtotime($note->created_at));
		}
		return response()->json(['success'=>true,'users'=>$notes],200);
	}
	public function updateStatus(Request $request,$id,$status){
		$users = self::$Quotations->where('id',$id)->update(['status' => $status]);
		return response()->json(['success'=>true,'message'=>'Record deleted successfully'],200);
	}
	public function create(Request $request){
		$validator = Validator::make($request->all(), [
			'title' => 'required',
			'description' => 'required'
			
		],[
			
			'title.required' => 'Please enter title.',
			'description.required' => 'Please enter description.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			
			if($errors->first('title')){
				return response()->json(['success'=>false, 'message' => $errors->first('title')]);
			}
			if($errors->first('description')){
				return response()->json(['success'=>false, 'message' => $errors->first('description')]);
			}
		}else{
			$setData['added_by'] = $GLOBALS['USER.ID'];
			$setData['title'] = $request->title;
			$setData['description'] = $request->description;
			self::$Quotations->create($setData);
			return response()->json(['success'=>true, 'message' => 'Quotation added successfully']);
		}
	}
	public function update(Request $request){
		$validator = Validator::make($request->all(), [
			'title' => 'required',
			'description' => 'required'
			
		],[
			'title.required' => 'Please enter title.',
			'description.required' => 'Please enter description.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('title')){
				return response()->json(['success'=>false, 'message' => $errors->first('title')]);
			}
			if($errors->first('description')){
				return response()->json(['success'=>false, 'message' => $errors->first('description')]);
			}
		}else{
			$setData['title'] = $request->title;
			$setData['description'] = $request->description;
				
				self::$Quotations->where('id',$request->id)->update($setData);
				return response()->json(['success'=>true, 'message' => 'Quotation updated successfully']);
		}
	}
	public function generatePdf(Request $request){
		
		$html = $this->GetPDFStructure($request->invoice_id);
		
		$fileName = 'quotation_'.$request->invoice_id.'.pdf';
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
		
		return response()->json(['success'=>true,'file_name'=>$fileName,'download_url' => env('APP_URL').$destination,'message'=>'Quotation generated successfully'],200);
	}
	public function GetPDFStructure($id){

		$InvoiceDetails = self::$Quotations->where('id', $id)->first();
		


		
		$storage_path = storage_path();

		$html = '<table cellspacing="0" width="100%">';
		$html .='<tr><td width="25%"><img width="150" src="'.self::$LogoController->getCoconutLogo().'"></td><td width="75%" style="font-family:tahoma;" colspan="3" ><h1 style="font-size:25px; padding-left:10px;">WEBD IT SOLUTIONS</h1><p style="margin-bottom:20px">Plot No: 62, Moti Nagar, Jhotwara, Jaipur, 302012, India</p><p><b>Deals In:</b> Web Development, Web Design, Web Hosting, Customised Softwares, IOS Application, Android Application, eCommerce Websites, CRM Development</p><p><b>Mobile:</b> +91-7737406899</p><p><b>Email:</b> webddh1989@gmail.com</p></td></tr>';
		
		$html .='<tr><td style="background-color:#000;font-size:5px;" colspan="4">aa</td></tr>';
		
		$html .='<tr><td height="40" style="font-family:tahoma;background-color:#E5E5E5;">&nbsp;&nbsp;<b>Quotation No.:</b> '.$InvoiceDetails->id.' </td><td style="font-family:tahoma;background-color:#E5E5E5;"><b></td><td style="font-family:tahoma;background-color:#E5E5E5;" align="right" colspan="2"><b>Quotation Date:</b> '.date('m F Y',strtotime($InvoiceDetails->created_at)).'</td></tr>';
		
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
		
		
		$html .='<tr><td colspan="4" >'.nl2br($InvoiceDetails->description).'</td></tr>';
		
		
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" height="30" colspan="4">aa</td></tr>';
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" height="30" colspan="4">aa</td></tr>';
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" height="30" colspan="4">aa</td></tr>';
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" height="30" colspan="4">aa</td></tr>';
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" height="30" colspan="4">aa</td></tr>';
		
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
		$html .='<tr><td style="background-color:#E5E5E5;" colspan="4"></td></tr>';
		$html .='<tr><td style="background-color:#fff;font-size:5px;color:#fff" colspan="4">aa</td></tr>';
	$html .='<tr><td colspan="4" style="font-family:tahoma;" align="center"><b>Thank You!</b></td></tr>';
		
			$html .= '</table>';
		return $html;
	}
}
