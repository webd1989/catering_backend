<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

class UserController extends Controller{

	private static $Users;
	private static $TokenHelper;
	
	public function __construct(){
		self::$Users = new Users();
		self::$TokenHelper = new TokenHelper();
		
	}
	public function getUser(Request $request){
		$user = self::$Users->where('id',$request->id)->first();
		return response()->json(['success'=>true,'user'=>$user],200);
	}
	public function getAllList(Request $request){
		$users = self::$Users->select('id','name')->where('type','Employee')->where('status','!=',3)->get();
		return response()->json(['success'=>true,'users'=>$users],200);
	}
	public function getList(Request $request){
		$query = self::$Users->where('type','Employee')->where('status','!=',3);
		
		if($request->input('search_key')  && $request->input('search_key') != ""){
            $SearchKeyword = $request->input('search_key');
            $query->where(function($query) use ($SearchKeyword)  {
                if(!empty($SearchKeyword)) {
                    $query->where('name', 'like', '%'.$SearchKeyword.'%') 
                    ->orWhere('email', 'like', '%'.$SearchKeyword.'%')
                    ->orWhere('phone', 'like', '%'.$SearchKeyword.'%');
                }
             });
		}
		
		$users = $query->paginate(10);
		foreach($users as $key => $user){
			$user->created_date = date('m/d/Y',strtotime($user->created_at));
		}
		return response()->json(['success'=>true,'users'=>$users],200);
	}
	public function saveLastLoginTime(Request $request){
		$currentTime = time();
		
		// Add 10 minutes to the current time
		$futureTime = strtotime('+10 minutes', $currentTime);
		
		// Format the future time for display
		$dateTime =  strtotime(date('Y-m-d H:i:s', $futureTime));
		$users = self::$Users->where('id',$GLOBALS['USER.ID'])->update(['last_login_date' => $dateTime]);
		return response()->json(['success'=>true,'dateTime'=>$dateTime],200);
	}
	public function checkLoginTime(Request $request){
		$userData = self::$Users->where('id',$GLOBALS['USER.ID'])->first();
		if(time() > $userData->last_login_date){
			return response()->json(['success'=>true,'message'=>'Logout'],200);
		}else{
			return response()->json(['success'=>false,'message'=>'NoLogout'],200);
		}
	}
	public function updateUserStatus(Request $request,$id,$status){
		$users = self::$Users->where('id',$id)->update(['status' => $status]);
		return response()->json(['success'=>true,'message'=>'Record deleted successfully'],200);
	}
	public function createUser(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'phone' => 'required|numeric',
			'email' => 'required|email',
			'password' => 'required'
			
		],[
			'name.required' => 'Please enter your name.',
			'phone.required' => 'Please enter your phone.',
			'email.required' => 'Please enter your email.',
			'email.email' => 'Please enter correct email.',
			'password.required' => 'Please enter your password.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('name')){
				return response()->json(['success'=>false, 'message' => $errors->first('name')]);
			}
			if($errors->first('phone')){
				return response()->json(['success'=>false, 'message' => $errors->first('phone')]);
			}
			if($errors->first('email')){
				return response()->json(['success'=>false, 'message' => $errors->first('email')]);
			}
			if($errors->first('password')){
				return response()->json(['success'=>false, 'message' => $errors->first('password')]);
			}
		}else{
			$emailCount = self::$Users->where('email',$request->email)->count();
			if($emailCount > 0){
				return response()->json(['success'=>false, 'message' => 'Email address already exist']);
			}
			$phoneCount = self::$Users->where('phone',$request->phone)->count();
			if($phoneCount > 0){
				return response()->json(['success'=>false, 'message' => 'Phone number already exist']);
			}
			$setData = [
			'name' => ucwords($request->name),
			'phone' => $request->phone,
			'email' => strtolower($request->email),
			'password' => password_hash($request->post('password'),PASSWORD_BCRYPT),
			'type' => 'Employee',
			'parent_id' => $GLOBALS['USER.ID']
			];
			self::$Users->create($setData);
			return response()->json(['success'=>true, 'message' => 'Employee added successfully']);
		}
	}
	public function updateUser(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'phone' => 'required|numeric',
			'email' => 'required|email'
			
		],[
			'name.required' => 'Please enter your name.',
			'phone.required' => 'Please enter your phone.',
			'email.required' => 'Please enter your email.',
			'email.email' => 'Please enter correct email.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('name')){
				return response()->json(['success'=>false, 'message' => $errors->first('name')]);
			}
			if($errors->first('phone')){
				return response()->json(['success'=>false, 'message' => $errors->first('phone')]);
			}
			if($errors->first('email')){
				return response()->json(['success'=>false, 'message' => $errors->first('email')]);
			}
		}else{
			$emailCount = self::$Users->where('email',$request->email)->where('id','!=',$request->id)->count();
			if($emailCount > 0){
				return response()->json(['success'=>false, 'message' => 'Email address already exist']);
			}
			$phoneCount = self::$Users->where('phone',$request->phone)->where('id','!=',$request->id)->count();
			if($phoneCount > 0){
				return response()->json(['success'=>false, 'message' => 'Phone number already exist']);
			}	
			$setData['name'] = ucwords($request->name);
			$setData['phone'] = $request->phone;
			$setData['email'] = strtolower($request->email);
			if($request->post('password') != ""){
				$setData['password'] = password_hash($request->post('password'),PASSWORD_BCRYPT);
			}
			
			self::$Users->where('id',$request->id)->update($setData);
			return response()->json(['success'=>true, 'message' => 'Employee updated successfully']);
			
		}
	}
}
