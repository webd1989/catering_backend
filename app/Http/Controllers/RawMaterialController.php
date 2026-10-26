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
use App\Models\RawMaterials;
use App\Models\Units;
use App\Models\MaterialCategories;
use Mpdf\Mpdf;

class RawMaterialController extends Controller{

	private static $Users;
	private static $TokenHelper;
	private static $RawMaterials;
	private static $LogoController;
	private static $Units;
	private static $MaterialCategories;
	
	public function __construct(){
		self::$Users = new Users();
		self::$TokenHelper = new TokenHelper();
		self::$RawMaterials = new RawMaterials();
		self::$LogoController = new LogoController();
		self::$Units = new Units();
		self::$MaterialCategories = new MaterialCategories();
		
	}
	public function getData(Request $request){
		$noteData = self::$RawMaterials->where('id',$request->id)->first();
		return response()->json(['success'=>true,'user'=>$noteData],200);
	}
	public function getListAll(Request $request){
		$records = self::$RawMaterials->where('category_id',$request->category_id)->where('status','!=',3)->orderBy('material_name','ASC')->get();
		return response()->json(['success'=>true,'records'=>$records],200);
	}
	public function getList(Request $request){
		$query = self::$RawMaterials->where('status','!=',3);
		if($request->input('title_search')  && $request->input('title_search') != ""){
            $query->where('material_name', 'like', '%'.$request->input('title_search').'%'); 
		}
		if($request->input('status_search')  && $request->input('status_search') != ""){
            $query->where('status',$request->input('status_search')); 
		}
		if($request->input('category_search')  && $request->input('category_search') != ""){
            $query->where('category_id',$request->input('category_search')); 
		}
		
		$notes = $query->orderBy('material_name','ASC')->paginate(10);
		
		foreach($notes as $key => $note){
			$cateName = '-';
			if($note->category_id > 0){
				$cateData = self::$MaterialCategories->where('id',$note->category_id)->first();
				$cateName = isset($cateData->title) ? $cateData->title : 'N/A';
			}
			$note->cate_name = $cateName;
			
			$unitName = '-';
			if($note->unit_id > 0){
				$unitData = self::$Units->where('id',$note->unit_id)->first();
				$unitName = $unitData->unit_name;
			}
			$note->unit_name = $unitName;
			
			$note->display_date = date('d F Y',strtotime($note->created_at));
		}
		return response()->json(['success'=>true,'users'=>$notes],200);
	}
	public function updateStatus(Request $request,$id,$status){
		$users = self::$RawMaterials->where('id',$id)->update(['status' => $status]);
		return response()->json(['success'=>true,'message'=>'Record deleted successfully'],200);
	}
	public function create(Request $request){
		$validator = Validator::make($request->all(), [
			'category_id' => 'required',
			'material_name' => 'required',
			'unit_id' => 'required'
			
		],[
			
			'category_id.required' => 'Please enter category_id.',
			'material_name.required' => 'Please enter material_name.',
			'unit_id.required' => 'Please enter unit_id.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			
			if($errors->first('category_id')){
				return response()->json(['success'=>false, 'message' => $errors->first('category_id')]);
			}
			if($errors->first('material_name')){
				return response()->json(['success'=>false, 'message' => $errors->first('material_name')]);
			}
			if($errors->first('unit_id')){
				return response()->json(['success'=>false, 'message' => $errors->first('unit_id')]);
			}
		}else{
			$setData['category_id'] = $request->category_id;
			$setData['material_name'] = $request->material_name;
			$setData['unit_id'] = $request->unit_id;
			$setData['current_stock'] = $request->current_stock;
			$setData['purchase_rate'] = $request->purchase_rate;
			self::$RawMaterials->create($setData);
			return response()->json(['success'=>true, 'message' => 'Record added successfully']);
		}
	}
	public function update(Request $request){
		$validator = Validator::make($request->all(), [
			'category_id' => 'required',
			'material_name' => 'required',
			'unit_id' => 'required'
			
		],[
			
			'category_id.required' => 'Please enter category_id.',
			'material_name.required' => 'Please enter material_name.',
			'unit_id.required' => 'Please enter unit_id.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('category_id')){
				return response()->json(['success'=>false, 'message' => $errors->first('category_id')]);
			}
			if($errors->first('material_name')){
				return response()->json(['success'=>false, 'message' => $errors->first('material_name')]);
			}
			if($errors->first('unit_id')){
				return response()->json(['success'=>false, 'message' => $errors->first('unit_id')]);
			}
		}else{
			$setData['category_id'] = $request->category_id;
			$setData['material_name'] = $request->material_name;
			$setData['unit_id'] = $request->unit_id;
			$setData['current_stock'] = $request->current_stock;
			$setData['purchase_rate'] = $request->purchase_rate;
				
				self::$RawMaterials->where('id',$request->id)->update($setData);
				return response()->json(['success'=>true, 'message' => 'Record updated successfully']);
		}
	}
}
