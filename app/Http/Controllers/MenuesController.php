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
use App\Models\Items;
use App\Models\Categories;
use App\Models\Menues;
use Mpdf\Mpdf;

class MenuesController extends Controller{

	private static $Users;
	private static $TokenHelper;
	private static $Items;
	private static $LogoController;
	private static $Categories;
	private static $Menues;
	
	public function __construct(){
		self::$Users = new Users();
		self::$TokenHelper = new TokenHelper();
		self::$Items = new Items();
		self::$LogoController = new LogoController();
		self::$Categories = new Categories();
		self::$Menues = new Menues();
		
	}
	public function getData(Request $request){
		$record = self::$Menues->where('id',$request->id)->first();
		return response()->json(['success'=>true,'record'=>$record],200);
	}
	public function getListAll(Request $request){
		$records = self::$Menues->where('status','!=',3)->where('category_id',$request->category_id)->orderBy('title','ASC')->get();
		return response()->json(['success'=>true,'records'=>$records],200);
	}
	public function getList(Request $request){
		
		$query = self::$Menues->where('status','!=',3);
		if($request->input('title_search')  && $request->input('title_search') != ""){
            $query->where('title', 'like', '%'.$request->input('title_search').'%'); 
		}
		if($request->input('status_search')  && $request->input('status_search') != ""){
            $query->where('status',$request->input('status_search')); 
		}
		
		if($request->input('category_id')  && $request->input('category_id') != ""){
            $query->where('category_id',$request->input('category_id')); 
		}
		
		if($request->input('sub_category_id')  && $request->input('sub_category_id') != ""){
            $query->where('sub_category_id',$request->input('sub_category_id')); 
		}
		
		$notes = $query->orderBy('title','ASC')->paginate(10);
		
		foreach($notes as $key => $note){

			$note->display_date = date('d F Y',strtotime($note->created_at));
			$cateName = '';
			if($note->category_id > 0){
				$cateData = self::$Categories->where('id',$note->category_id)->first();
				$cateName = $cateData->title;
			}
			$note->cate_name = $cateName;
			
			$subCateName = '-';
			if($note->sub_category_id > 0){
				$subCateData = self::$Categories->where('id',$note->sub_category_id)->first();
				$subCateName = $subCateData->title;
			}
			$note->sub_cate_name = $subCateName;
		}
		return response()->json(['success'=>true,'users'=>$notes],200);
	}
	public function updateStatus(Request $request,$id,$status){
		$users = self::$Menues->where('id',$id)->update(['status' => $status]);
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
			$setData['customer_name'] = $request->customer_name;
			$setData['customer_phone'] = $request->customer_phone;
			$setData['function_date'] = $request->function_date;
			$setData['location'] = $request->location;
			$setData['no_of_guest'] = $request->no_of_guest;
			$setData['menu_item'] = json_encode($request->menu_item);
			self::$Menues->create($setData);
			return response()->json(['success'=>true, 'message' => 'Record added successfully']);
		}
	}
	public function createByAi(Request $request){
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
			$items=[];
			$counter = 0;
			foreach($request->menu_item as $key => $menuItem){
				if($menuItem['category_id'] > 0 && $menuItem['no_of_item'] > 0){
					$menuIds = [];
					$itemRecords = self::$Items->where('status','!=',3)->where('category_id',$menuItem['category_id'])->inRandomOrder()->take($menuItem['no_of_item'])->get();
					foreach($itemRecords as $key => $itemRecord){
						$menuIds[] = $itemRecord->id;
					}
					$items[$counter]['category_id'] = $menuItem['category_id'];
					$items[$counter]['menu_items'] = $menuIds;
					
					$counter++;
				}
				
			}
			
			
			$setData['added_by'] = $GLOBALS['USER.ID'];
			$setData['title'] = $request->title;
			$setData['description'] = $request->description;
			$setData['customer_name'] = $request->customer_name;
			$setData['customer_phone'] = $request->customer_phone;
			$setData['function_date'] = $request->function_date;
			$setData['location'] = $request->location;
			$setData['no_of_guest'] = $request->no_of_guest;
			$setData['menu_item'] = json_encode($items);
			self::$Menues->create($setData);
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
			$setData['customer_name'] = $request->customer_name;
			$setData['customer_phone'] = $request->customer_phone;
			$setData['function_date'] = $request->function_date;
			$setData['location'] = $request->location;
			$setData['no_of_guest'] = $request->no_of_guest;
			$setData['menu_item'] = json_encode($request->menu_item);
				
			self::$Menues->where('id',$request->id)->update($setData);
			return response()->json(['success'=>true, 'message' => 'Record updated successfully']);
		}
	}
}
