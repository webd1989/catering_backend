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
use App\Models\Ingredients;
use App\Models\RawMaterials;
use Mpdf\Mpdf;

class ItemsController extends Controller{

	private static $Users;
	private static $TokenHelper;
	private static $Items;
	private static $LogoController;
	private static $Categories;
	private static $Ingredients;
	private static $RawMaterials;
	
	public function __construct(){
		self::$Users = new Users();
		self::$TokenHelper = new TokenHelper();
		self::$Items = new Items();
		self::$LogoController = new LogoController();
		self::$Categories = new Categories();
		self::$Ingredients = new Ingredients();
		self::$RawMaterials = new RawMaterials();
	}
	public function getData(Request $request){
		$noteData = self::$Items->where('id',$request->id)->first();
		$noteData->sub_categories = self::$Categories->where('status','!=',3)->where('parent_id',$noteData->category_id)->orderBy('title','ASC')->get();
		$result = [];
		$ingredients = self::$Ingredients->where('item_id',$request->id)->get();
		foreach($ingredients as $key => $ingredient){
		$ingredient->materials = self::$RawMaterials->where('category_id',$ingredient->material_category_id)->where('status','!=',3)->get();
		}	
		$noteData->ingredients = $ingredients;
		return response()->json(['success'=>true,'user'=>$noteData],200);
	}
	public function getListAll(Request $request){
		$records = self::$Items->where('status','!=',3)->where('category_id',$request->category_id)->orderBy('title','ASC')->get();
		foreach($records as $key => $record){
			$record->selected = false;
			if($request->selected){
			if(in_array($record->id,$request->selected)){
				$record->selected = true;
			}
			}
		}
		return response()->json(['success'=>true,'records'=>$records],200);
	}
	public function getList(Request $request){
		
		/*$drinks = [
    "Loki Halwa",
    "Pineapple Halwa",
    "Dal Badam Halwa",
    "Gajar Halwa",
    "Akhrot Halwa",
    "Suji Halwa",
    "Apple Halwa",
    "Hara Chole Barfi",
    "Dal Badam Barfi",
    "Kesar Barfi",
    "Thal Ki Barfi",
    "Pineapple Barfi",
    "Moti Pak",
    "Baked Malpua",
    "Malpua With Santra Giri",
    "Baked Boondi",
    "Kesar Pista Dil Jani",
    "Rabdi Malpua",
    "Gulab Jamun (Plain)",
    "Stuffed Gulab Jamun",
    "Mung Rasbhari",
    "Meva Gunji",
    "Mishri Mava",
    "Mini Finni",
    "Kesar Jalebi",
    "Baked Gulab Jamun",
    "Mini Ghewar",
    "Dry Fruit Kheer",
    "Pantua",
    "Kala Gulab Jamun",
    "Mawa Kachori",
    "Mango Mishri Mava",
    "Gud Ka Mishri Mava",
    "Makkhan Wada",
    "Trio Mishri Mawa",
    "Shahi Tukda"
];
		
		foreach($drinks as $key => $drink){
			$setData['added_by'] = $GLOBALS['USER.ID'];
			$setData['title'] = $drink;
			$setData['description'] = NULL;
			$setData['category_id'] = 27;
			self::$Items->create($setData);
		}*/
		
		$query = self::$Items->where('status','!=',3);
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
		$users = self::$Items->where('id',$id)->update(['status' => $status]);
		return response()->json(['success'=>true,'message'=>'Record deleted successfully'],200);
	}
	public function create(Request $request){
		$validator = Validator::make($request->all(), [
			'category_id' => 'required|numeric',
			'title' => 'required'
			
		],[
			
			'category_id.required' => 'Please enter title.',
			'title.required' => 'Please enter title.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			
			if($errors->first('category_id')){
				return response()->json(['success'=>false, 'message' => $errors->first('category_id')]);
			}
			if($errors->first('title')){
				return response()->json(['success'=>false, 'message' => $errors->first('title')]);
			}
		}else{
			$setData['added_by'] = $GLOBALS['USER.ID'];
			$setData['title'] = $request->title;
			$setData['description'] = $request->description;
			$setData['category_id'] = $request->category_id;
			$setData['sub_category_id'] = $request->sub_category_id;
			$setData['per_person_price'] = $request->per_person_price;
			self::$Items->create($setData);
			return response()->json(['success'=>true, 'message' => 'Record added successfully']);
		}
	}
	public function update(Request $request){
		$validator = Validator::make($request->all(), [
			'category_id' => 'required|numeric',
			'title' => 'required'
			
		],[
			
			'category_id.required' => 'Please enter title.',
			'title.required' => 'Please enter title.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('category_id')){
				return response()->json(['success'=>false, 'message' => $errors->first('category_id')]);
			}
			if($errors->first('title')){
				return response()->json(['success'=>false, 'message' => $errors->first('title')]);
			}
		}else{
			$setData['title'] = $request->title;
			$setData['per_person_price'] = $request->per_person_price;
			$setData['description'] = $request->description ? $request->description : NULL;
			$setData['category_id'] = $request->category_id;
			$setData['sub_category_id'] = $request->sub_category_id && $request->sub_category_id > 0 ? $request->sub_category_id : 0;
			$setData['cooking_method'] = $request->cooking_method ? $request->cooking_method : NULL;
				
			self::$Items->where('id',$request->id)->update($setData);
			
			if($request->ingredients && is_array($request->ingredients)){
				
				foreach($request->ingredients as $ingredient){
					if($ingredient['material_category_id'] > 0 && $ingredient['raw_material_id'] > 0 && $ingredient['qty'] > 0 && $ingredient['unit'] != ''){
						if($ingredient['id'] > 0){
							$setData1['material_category_id'] = $ingredient['material_category_id'];
							$setData1['raw_material_id'] = $ingredient['raw_material_id'];
							$setData1['unit'] = $ingredient['unit'];
							$setData1['qty'] = $ingredient['qty'];
							self::$Ingredients->where('id',$ingredient['id'])->update($setData1);
						}else{
							$setData2['item_id'] = $request->id;
							$setData2['material_category_id'] = $ingredient['material_category_id'];
							$setData2['raw_material_id'] = $ingredient['raw_material_id'];
							$setData2['unit'] = $ingredient['unit'];
							$setData2['qty'] = $ingredient['qty'];
							self::$Ingredients->create($setData2);
	
						}
					}else{
						return response()->json(['success'=>false, 'message' => 'Please enter receipe quantity']);
					}
				}
			
			}
			
			return response()->json(['success'=>true, 'message' => 'Record updated successfully']);
		}
	}
}
