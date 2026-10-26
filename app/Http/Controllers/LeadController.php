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
use App\Models\Leads;
use Mpdf\Mpdf;

class LeadController extends Controller{

	private static $Users;
	private static $TokenHelper;
	private static $Leads;
	private static $LogoController;
	
	public function __construct(){
		self::$Users = new Users();
		self::$TokenHelper = new TokenHelper();
		self::$Leads = new Leads();
		self::$LogoController = new LogoController();
		
	}
	public function getData(Request $request){
		$noteData = self::$Leads->where('id',$request->id)->first();
		return response()->json(['success'=>true,'user'=>$noteData],200);
	}
	public function getListAll(Request $request){
		$records = self::$Leads->where('status','!=',3)->where('parent_id',0)->orderBy('title','ASC')->get();
		return response()->json(['success'=>true,'records'=>$records],200);
	}
	public function getList(Request $request){
		$query = self::$Leads;

		if($request->input('full_name')  && $request->input('full_name') != ""){
            $query = $query->where('full_name', 'like', '%'.$request->input('full_name').'%'); 
		}
		if($request->input('mobile')  && $request->input('mobile') != ""){
            $query = $query->where('mobile', 'like', '%'.$request->input('mobile').'%'); 
		}
		
		$records = $query->orderBy('lead_id','DESC')->paginate(10);
		
		foreach($records as $key => $record){

			$record->display_date = date('d F Y',strtotime($record->created_at));
		}
		return response()->json(['success'=>true,'users'=>$records],200);
	}
	public function updateStatus(Request $request,$id,$status){
		$users = self::$Leads->where('id',$id)->update(['status' => $status]);
		return response()->json(['success'=>true,'message'=>'Record deleted successfully'],200);
	}
	public function create(Request $request){
		$validator = Validator::make($request->all(), [
			'title' => 'required'
			
		],[
			
			'title.required' => 'Please enter title.'
			
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
			$setData['parent_id'] = $request->parent_id;
			self::$Leads->create($setData);
			return response()->json(['success'=>true, 'message' => 'Record added successfully']);
		}
	}
	public function update(Request $request){
		$validator = Validator::make($request->all(), [
			'title' => 'required'
			
		],[
			'title.required' => 'Please enter title.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('title')){
				return response()->json(['success'=>false, 'message' => $errors->first('title')]);
			}
		}else{
			$setData['title'] = $request->title;
			$setData['description'] = $request->description;
			$setData['parent_id'] = $request->parent_id;
				
				self::$Leads->where('id',$request->id)->update($setData);
				return response()->json(['success'=>true, 'message' => 'Record updated successfully']);
		}
	}
}
