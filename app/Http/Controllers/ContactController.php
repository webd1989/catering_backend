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
use App\Models\Customers;

class ContactController extends Controller{

	private static $Users;
	private static $TokenHelper;
	private static $Customers;
	
	public function __construct(){
		self::$Users = new Users();
		self::$TokenHelper = new TokenHelper();
		self::$Customers = new Customers();
		
	}
	public function getContact(Request $request){
		if($request->id > 0){
			$user = self::$Customers->where('id',$request->id)->first();
		}
		if($request->phone && $request->phone != ""){
			$user = self::$Customers->where('phone',$request->phone)->first();
		}
		return response()->json(['success'=>true,'user'=>$user],200);
	}
	public function getListAll(Request $request){
		$query = self::$Customers->where('status','!=',3)->orderBy('company','ASC')->get();
		return response()->json(['success'=>true,'users'=>$query],200);
	}
	public function getList(Request $request){
		
		$loginUserData = self::$Users->select('type')->where('id',$GLOBALS['USER.ID'])->first();
		
		$query = self::$Customers->where('status','!=',3);
		
		
		if($request->input('search_key')  && $request->input('search_key') != ""){
            $SearchKeyword = $request->input('search_key');
            $query->where(function($query) use ($SearchKeyword)  {
                if(!empty($SearchKeyword)) {
                    $query->where('name', 'like', '%'.$SearchKeyword.'%') 
                    ->orWhere('email', 'like', '%'.$SearchKeyword.'%')
					->orWhere('city', 'like', '%'.$SearchKeyword.'%')
                    ->orWhere('phone', 'like', '%'.$SearchKeyword.'%');
                }
             });
		}
		
		$users = $query->paginate(50);
		foreach($users as $key => $user){
			$user->created_date = date('m/d/Y',strtotime($user->created_at));
			$user->company = strlen($user->company) > 20 ? substr($user->company,0,20).'...' : $user->company;
			$user->name = strlen($user->name) > 20 ? substr($user->name,0,20).'...' : $user->name;
			$user->email = strlen($user->email) > 20 ? substr($user->email,0,20).'...' : $user->email;
		}
		return response()->json(['success'=>true,'users'=>$users],200);
	}
	public function updateContactStatus(Request $request,$id,$status){
		$users = self::$Customers->where('id',$id)->update(['status' => $status]);
		return response()->json(['success'=>true,'message'=>'Record deleted successfully'],200);
	}
	public function createContact(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required'
			
		],[
			'name.required' => 'Please enter your name.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('name')){
				return response()->json(['success'=>false, 'message' => $errors->first('name')]);
			}
		}else{

			$setData['added_by'] = $GLOBALS['USER.ID'];
			$setData['name'] = $request->name;
			$setData['phone'] = $request->phone;
			$setData['email'] = $request->email;
			$setData['address'] = $request->address;
			$setData['city'] = $request->city;
			$setData['gst_no'] = $request->gst_no;
			$setData['company'] = $request->company;
			$setData['description'] = $request->description;
			self::$Customers->create($setData);
			return response()->json(['success'=>true, 'message' => 'Customer added successfully']);
			
		}
	}
	public function updateContact(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required'
			
		],[
			'name.required' => 'Please enter your name.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('name')){
				return response()->json(['success'=>false, 'message' => $errors->first('name')]);
			}
		}else{

			$setData['name'] = $request->name;
			$setData['phone'] = $request->phone;
			$setData['email'] = $request->email;
			$setData['address'] = $request->address;
			$setData['city'] = $request->city;
			$setData['gst_no'] = $request->gst_no;
			$setData['company'] = $request->company;
			$setData['description'] = $request->description;
			
			self::$Customers->where('id',$request->id)->update($setData);
			return response()->json(['success'=>true, 'message' => 'Customer updated successfully']);
		}
	}
}
