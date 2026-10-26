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
use App\Models\LogisticRanges;
use Mpdf\Mpdf;

class LogisticRangeController extends Controller{

	private static $Users;
	private static $TokenHelper;
	private static $LogisticRanges;
	private static $LogoController;
	
	public function __construct(){
		self::$Users = new Users();
		self::$TokenHelper = new TokenHelper();
		self::$LogisticRanges = new LogisticRanges();
		self::$LogoController = new LogoController();
		
	}
	public function getData(Request $request){
		$noteData = self::$LogisticRanges->where('id',$request->id)->first();
		return response()->json(['success'=>true,'user'=>$noteData],200);
	}
	public function getListAll(Request $request){
		$records = self::$LogisticRanges->where('status','!=',3)->orderBy('title','ASC')->get();
		return response()->json(['success'=>true,'records'=>$records],200);
	}
	public function getList(Request $request){
		$query = self::$LogisticRanges->where('status','!=',3);
		if($request->input('title_search')  && $request->input('title_search') != ""){
            $query->where('title', 'like', '%'.$request->input('title_search').'%'); 
		}
		if($request->input('status_search')  && $request->input('status_search') != ""){
            $query->where('status',$request->input('status_search')); 
		}
		
		$notes = $query->orderBy('id','ASC')->paginate(10);
		
		foreach($notes as $key => $note){

			$note->display_date = date('d F Y',strtotime($note->created_at));
		}
		return response()->json(['success'=>true,'users'=>$notes],200);
	}
	public function updateStatus(Request $request,$id,$status){
		$users = self::$LogisticRanges->where('id',$id)->update(['status' => $status]);
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
			$setData['amount'] = $request->amount;
			self::$LogisticRanges->create($setData);
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
			$setData['amount'] = $request->amount;
				
				self::$LogisticRanges->where('id',$request->id)->update($setData);
				return response()->json(['success'=>true, 'message' => 'Record updated successfully']);
		}
	}
}
