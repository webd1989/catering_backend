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
use App\Models\Units;
use Mpdf\Mpdf;

class UnitController extends Controller{

	private static $Users;
	private static $TokenHelper;
	private static $Units;
	private static $LogoController;
	
	public function __construct(){
		self::$Users = new Users();
		self::$TokenHelper = new TokenHelper();
		self::$Units = new Units();
		self::$LogoController = new LogoController();
		
	}
	public function getData(Request $request){
		$noteData = self::$Units->where('id',$request->id)->first();
		return response()->json(['success'=>true,'user'=>$noteData],200);
	}
	public function getListAll(Request $request){
		$records = self::$Units->where('status','!=',3)->orderBy('unit_name','ASC')->get();
		return response()->json(['success'=>true,'records'=>$records],200);
	}
	public function getList(Request $request){
		$query = self::$Units->where('status','!=',3);
		if($request->input('title_search')  && $request->input('title_search') != ""){
            $query->where('unit_name', 'like', '%'.$request->input('title_search').'%'); 
		}
		if($request->input('status_search')  && $request->input('status_search') != ""){
            $query->where('status',$request->input('status_search')); 
		}
		
		$notes = $query->orderBy('unit_name','ASC')->paginate(10);
		
		foreach($notes as $key => $note){

			$note->display_date = date('d F Y',strtotime($note->created_at));
		}
		return response()->json(['success'=>true,'users'=>$notes],200);
	}
	public function updateStatus(Request $request,$id,$status){
		$users = self::$Units->where('id',$id)->update(['status' => $status]);
		return response()->json(['success'=>true,'message'=>'Record deleted successfully'],200);
	}
	public function create(Request $request){
		$validator = Validator::make($request->all(), [
			'unit_name' => 'required',
			'short_name' => 'required'
			
		],[
			
			'unit_name.required' => 'Please enter unit name.',
			'short_name.required' => 'Please enter short name.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			
			if($errors->first('unit_name')){
				return response()->json(['success'=>false, 'message' => $errors->first('unit_name')]);
			}
			if($errors->first('short_name')){
				return response()->json(['success'=>false, 'message' => $errors->first('short_name')]);
			}
		}else{
			$setData['added_by'] = $GLOBALS['USER.ID'];
			$setData['unit_name'] = $request->unit_name;
			$setData['short_name'] = $request->short_name;
			self::$Units->create($setData);
			return response()->json(['success'=>true, 'message' => 'Record added successfully']);
		}
	}
	public function update(Request $request){
		$validator = Validator::make($request->all(), [
			'unit_name' => 'required',
			'short_name' => 'required'
			
		],[
			
			'unit_name.required' => 'Please enter unit name.',
			'short_name.required' => 'Please enter short name.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('unit_name')){
				return response()->json(['success'=>false, 'message' => $errors->first('unit_name')]);
			}
			if($errors->first('short_name')){
				return response()->json(['success'=>false, 'message' => $errors->first('short_name')]);
			}
		}else{
			$setData['unit_name'] = $request->unit_name;
			$setData['short_name'] = $request->short_name;
				
				self::$Units->where('id',$request->id)->update($setData);
				return response()->json(['success'=>true, 'message' => 'Record updated successfully']);
		}
	}
}
