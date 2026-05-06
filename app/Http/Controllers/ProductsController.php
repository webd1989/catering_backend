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
use App\Models\Projects;
use App\Models\Customers;

class ProductsController extends Controller{

	private static $Users;
	private static $TokenHelper;
	private static $Projects;
	private static $Customers;
	
	public function __construct(){
		self::$Users = new Users();
		self::$TokenHelper = new TokenHelper();
		self::$Projects = new Projects();
		self::$Customers = new Customers();
		
	}
	public function getProject(Request $request){
		if($request->id > 0){
			$user = self::$Projects->where('id',$request->id)->first();
		}
		if($request->phone && $request->phone != ""){
			$user = self::$Projects->where('phone',$request->phone)->first();
		}
		return response()->json(['success'=>true,'user'=>$user],200);
	}
	public function getListAll(Request $request){
		$query = self::$Projects->where('status','!=',3)->orderBy('name','ASC')->get();
		return response()->json(['success'=>true,'users'=>$query],200);
	}
	public function getList(Request $request){
		
		$loginUserData = self::$Users->select('type')->where('id',$GLOBALS['USER.ID'])->first();
		
		$query = self::$Projects->where('status','!=',3);
		
		
		if($request->input('customer_name')  && $request->input('customer_name') != ""){
            $query->where('customer_id',$request->input('customer_name'));
		}
		if($request->input('status')  && $request->input('status') != ""){
            $query->where('status',$request->input('status'));
		}
		
		$users = $query->orderBy('id','DESC')->paginate(50);
		foreach($users as $key => $user){
			$client = self::$Customers->where('id',$user->customer_id)->first();
			$user->company = strlen($client->company) > 20 ? substr($client->company,0,20).'...' : $client->company;
			$user->company_full = $client->company;
			$user->title = strlen($user->title) > 20 ? substr($user->title,0,20).'...' : $user->title;
			$user->title_full = $user->title;
			$user->created_date = date('m/d/Y',strtotime($user->created_at));
		}
		return response()->json(['success'=>true,'users'=>$users],200);
	}
	public function updateProjectStatus(Request $request,$id,$status){
		$users = self::$Projects->where('id',$id)->update(['status' => $status]);
		return response()->json(['success'=>true,'message'=>'Record deleted successfully'],200);
	}
	public function createProject(Request $request){
		$validator = Validator::make($request->all(), [
			'title' => 'required'
			
		],[
			'title.required' => 'Please enter your title.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('title')){
				return response()->json(['success'=>false, 'message' => $errors->first('title')]);
			}
		}else{

			$setData['added_by'] = $GLOBALS['USER.ID'];
			$setData['title'] = $request->title;
			$setData['description'] = $request->description;
			$setData['customer_id'] = $request->customer_id;
			self::$Projects->create($setData);
			return response()->json(['success'=>true, 'message' => 'Project added successfully']);
			
		}
	}
	public function updateProject(Request $request){
		$validator = Validator::make($request->all(), [
			'title' => 'required'
			
		],[
			'title.required' => 'Please enter your title.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('title')){
				return response()->json(['success'=>false, 'message' => $errors->first('title')]);
			}
		}else{

			$setData['title'] = $request->title;
			$setData['description'] = $request->description;
			$setData['customer_id'] = $request->customer_id;
			
			self::$Projects->where('id',$request->id)->update($setData);
			return response()->json(['success'=>true, 'message' => 'Project updated successfully']);
		}
	}
}
