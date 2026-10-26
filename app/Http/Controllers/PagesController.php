<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Validation\Rule;
use ReallySimpleJWT\Token;
use App\Models\Leads;
use App\Models\Users;
use App\Models\Responses;
use Session;
use App\Models\TokenHelper;

class PagesController extends Controller{

	private static $Users;
	private static $Leads;
	private static $TokenHelper;
	
	public function __construct(){
		self::$Users = new Users();
		self::$Leads = new Leads();
		self::$TokenHelper = new TokenHelper();
		
	}
	public function index(Request $request){
		//$user = self::$Users->where('id',$request->id)->first();
		return view('/pages/index');
	}
	public function aboutUs(Request $request){
		//$user = self::$Users->where('id',$request->id)->first();
		return view('/pages/about-us');
	}
	public function services(Request $request){
		//$user = self::$Users->where('id',$request->id)->first();
		return view('/pages/services');
	}
	public function contactUs(Request $request){
		//$user = self::$Users->where('id',$request->id)->first();
		return view('/pages/contact-us');
	}
	public function gallery(Request $request){
		//$user = self::$Users->where('id',$request->id)->first();
		return view('/pages/gallery');
	}
	public function saveContact(Request $request){
		$validator = Validator::make($request->all(), [
			'firstname' => 'required',
			'lastname' => 'required',
			'email_address' => 'required|email',
			'phone' => 'required|digits:10',
			'message' => 'required'
			
		],[
			
			'firstname.required' => 'Please enter firstname.',
			'lastname.required' => 'Please enter lastname.',
			'email_address.required' => 'Please enter email address.',
			'phone.required' => 'Please enter phone.',
			'message.required' => 'Please enter message.',
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();

			if($errors->first('firstname')){
				echo json_encode(['success'=>false, 'message' => $errors->first('firstname')]); die;
			}
			if($errors->first('lastname')){
				echo json_encode(['success'=>false, 'message' => $errors->first('lastname')]); die;
			}
			if($errors->first('email_address')){
				echo json_encode(['success'=>false, 'message' => $errors->first('email_address')]); die;
			}
			if($errors->first('phone')){
				echo json_encode(['success'=>false, 'message' => $errors->first('phone')]); die;
			}
			if($errors->first('message')){
				echo json_encode(['success'=>false, 'message' => $errors->first('message')]); die;
			}
		}else{
			$setData['lead_code'] = rand(10001,99999);
			$setData['full_name'] = ucwords($request->firstname.' '.$request->lastname);
			$setData['email'] = $request->email_address;
			$setData['mobile'] = $request->phone;
			$setData['customer_phone'] = $request->customer_phone;
			$setData['comments'] = $request->message;
			self::$Leads->create($setData);
			echo json_encode(['success'=>true, 'message' => 'Your enquiry sent successfully']);
		}
	}
}
