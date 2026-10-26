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
use App\Models\MaterialPurchases;
use App\Models\MaterialPurchaseItems;
use App\Models\Customers;
use App\Models\RawMaterials;
use Mpdf\Mpdf;

class PurchaseController extends Controller{

	private static $Users;
	private static $TokenHelper;
	private static $Items;
	private static $LogoController;
	private static $Categories;
	private static $MaterialPurchases;
	private static $MaterialPurchaseItems;
	private static $Customers;
	private static $RawMaterials;
	
	public function __construct(){
		self::$Users = new Users();
		self::$TokenHelper = new TokenHelper();
		self::$Items = new Items();
		self::$LogoController = new LogoController();
		self::$Categories = new Categories();
		self::$MaterialPurchases = new MaterialPurchases();
		self::$MaterialPurchaseItems = new MaterialPurchaseItems();
		self::$Customers = new Customers();
		self::$RawMaterials = new RawMaterials();
		
	}
	public function getData(Request $request){
		$record = self::$MaterialPurchases->where('id',$request->id)->first();
		$items = self::$MaterialPurchaseItems->where('purchase_id',$record->id)->get();
		foreach($items as $key => $item){
			$item->materials = self::$RawMaterials->where('category_id',$item->material_category_id)->get();
		}
		$record->items = $items;
		return response()->json(['success'=>true,'record'=>$record],200);
	}
	public function getListAll(Request $request){
		$records = self::$MaterialPurchases->where('status','!=',3)->where('category_id',$request->category_id)->orderBy('title','ASC')->get();
		return response()->json(['success'=>true,'records'=>$records],200);
	}
	public function getList(Request $request){
		
		$query = self::$MaterialPurchases;
		
		if($request->input('supplier_id')  && $request->input('supplier_id') != ""){
            $query = $query->where('supplier_id',$request->input('supplier_id')); 
		}
		
		$notes = $query->orderBy('id','DESC')->paginate(10);
		
		foreach($notes as $key => $note){

			$note->display_date = date('d F Y',strtotime($note->created_at));
			$note->display_purchase_date = date('d F Y',strtotime($note->purchase_date));
			
			$subCateName = '-';
			if($note->supplier_id > 0){
				$subCateData = self::$Customers->where('id',$note->supplier_id)->first();
				$subCateName = $subCateData->company;
			}
			$note->vendor_name = $subCateName;
		}
		return response()->json(['success'=>true,'users'=>$notes],200);
	}
	public function updateStatus(Request $request,$id,$status){
		$users = self::$MaterialPurchases->where('id',$id)->update(['status' => $status]);
		return response()->json(['success'=>true,'message'=>'Record deleted successfully'],200);
	}
	public function create(Request $request){
		$validator = Validator::make($request->all(), [
			'supplier_id' => 'required',
			'purchase_date' => 'required',
			'subtotal' => 'required',
			'gst_amount' => 'required',
			'total_amount' => 'required',
			'invoice_no' => 'required'
			
		],[
			
			'supplier_id.required' => 'Please select vendor.',
			'purchase_date.required' => 'Please enter purchase date.',
			'subtotal.required' => 'Please enter sub total.',
			'gst_amount.required' => 'Please enter gst amount.',
			'total_amount.required' => 'Please enter total amount.',
			'invoice_no.required' => 'Please enter invoice no.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();

			if($errors->first('supplier_id')){
				return response()->json(['success'=>false, 'message' => $errors->first('supplier_id')]);
			}
			if($errors->first('purchase_date')){
				return response()->json(['success'=>false, 'message' => $errors->first('purchase_date')]);
			}
			if($errors->first('subtotal')){
				return response()->json(['success'=>false, 'message' => $errors->first('subtotal')]);
			}
			if($errors->first('gst_amount')){
				return response()->json(['success'=>false, 'message' => $errors->first('gst_amount')]);
			}
			if($errors->first('total_amount')){
				return response()->json(['success'=>false, 'message' => $errors->first('total_amount')]);
			}
			if($errors->first('invoice_no')){
				return response()->json(['success'=>false, 'message' => $errors->first('invoice_no')]);
			}
		}else{
			$setData['supplier_id'] = $request->supplier_id;
			$setData['purchase_date'] = $request->purchase_date;
			$setData['subtotal'] = $request->subtotal;
			$setData['gst_amount'] = $request->gst_amount;
			$setData['total_amount'] = ($request->subtotal+$request->gst_amount);
			$setData['remarks'] = $request->remarks;
			$setData['invoice_no'] = $request->invoice_no;
			$purchaseRecord = self::$MaterialPurchases->create($setData);
			
			foreach($request->items as $key => $item){
				if($item['material_category_id'] > 0 && $item['raw_material_id'] > 0 && $item['qty'] > 0 && $item['rate'] > 0 && $item['total'] > 0 && $item['unit'] != ''){
					$setData2['purchase_id'] = $purchaseRecord->id;
					$setData2['material_category_id'] = $item['material_category_id'];
					$setData2['material_id'] = $item['raw_material_id'];
					$setData2['qty'] = $item['qty'];
					$setData2['rate'] = $item['rate'];
					$setData2['amount'] = $item['total'];
					$setData2['unit'] = $item['unit'];
					self::$MaterialPurchaseItems->create($setData2);
					
					$rowData = self::$RawMaterials->where('id',$item['raw_material_id'])->first();
					$newQty = $rowData->current_stock+$item['qty'];
					self::$RawMaterials->where('id',$item['raw_material_id'])->update(['current_stock' => $newQty,'purchase_rate' => $item['rate']]);
				}
			}
			
			return response()->json(['success'=>true, 'message' => 'Record added successfully']);
		}
	}

	public function update(Request $request){
		$validator = Validator::make($request->all(), [
			'supplier_id' => 'required',
			'purchase_date' => 'required',
			'subtotal' => 'required',
			'gst_amount' => 'required',
			'total_amount' => 'required',
			'invoice_no' => 'required'
			
		],[
			
			'supplier_id.required' => 'Please select vendor.',
			'purchase_date.required' => 'Please enter purchase date.',
			'subtotal.required' => 'Please enter sub total.',
			'gst_amount.required' => 'Please enter gst amount.',
			'total_amount.required' => 'Please enter total amount.',
			'invoice_no.required' => 'Please enter invoice no.'
			
		]);
		if($validator->fails()){
			$errors = $validator->errors();
			if($errors->first('supplier_id')){
				return response()->json(['success'=>false, 'message' => $errors->first('supplier_id')]);
			}
			if($errors->first('purchase_date')){
				return response()->json(['success'=>false, 'message' => $errors->first('purchase_date')]);
			}
			if($errors->first('subtotal')){
				return response()->json(['success'=>false, 'message' => $errors->first('subtotal')]);
			}
			if($errors->first('gst_amount')){
				return response()->json(['success'=>false, 'message' => $errors->first('gst_amount')]);
			}
			if($errors->first('total_amount')){
				return response()->json(['success'=>false, 'message' => $errors->first('total_amount')]);
			}
			if($errors->first('invoice_no')){
				return response()->json(['success'=>false, 'message' => $errors->first('invoice_no')]);
			}
		}else{
			$setData['supplier_id'] = $request->supplier_id;
			$setData['purchase_date'] = $request->purchase_date;
			$setData['subtotal'] = $request->subtotal;
			$setData['gst_amount'] = $request->gst_amount;
			$setData['total_amount'] = ($request->subtotal+$request->gst_amount);
			$setData['remarks'] = $request->remarks;
			$setData['invoice_no'] = $request->invoice_no;
				
			self::$MaterialPurchases->where('id',$request->id)->update($setData);
			
			foreach($request->items as $key => $item){
				if($item['material_category_id'] > 0 && $item['raw_material_id'] > 0 && $item['qty'] > 0 && $item['rate'] > 0 && $item['total'] > 0 && $item['unit'] != ''){
					$setData2['purchase_id'] = $request->id;
					$setData2['material_category_id'] = $item['material_category_id'];
					$setData2['material_id'] = $item['raw_material_id'];
					$setData2['qty'] = $item['qty'];
					$setData2['rate'] = $item['rate'];
					$setData2['amount'] = $item['total'];
					$setData2['unit'] = $item['unit'];
					if($item['id'] > 0){
						
						$oldRecord = self::$MaterialPurchaseItems->where('id',$item['id'])->first();
						if($item['qty'] != $oldRecord->qty){
							if($item['qty'] > $oldRecord->qty){
								$extraQty = $item['qty']-$oldRecord->qty;
								$rowData = self::$RawMaterials->where('id',$item['raw_material_id'])->first();
								$newQty = $rowData->current_stock+$extraQty;
								self::$RawMaterials->where('id',$item['raw_material_id'])->update(['current_stock' => $newQty,'purchase_rate' => $item['rate']]);
								self::$MaterialPurchaseItems->where('id',$item['id'])->update($setData2);
							}else{
								$extraMinusQty = $oldRecord->qty-$item['qty'];
								$rowData = self::$RawMaterials->where('id',$item['raw_material_id'])->first();
								if($rowData->current_stock > $extraMinusQty){
									$newQty = $rowData->current_stock-$extraMinusQty;
									self::$RawMaterials->where('id',$item['raw_material_id'])->update(['current_stock' => $newQty,'purchase_rate' => $item['rate']]);
									self::$MaterialPurchaseItems->where('id',$item['id'])->update($setData2);
								}else{
									return response()->json(['success'=>false, 'message' => $rowData->material_name.' qty cannot update, because current stock is used.']);
								}
							}
						}
						
						
						
						
					}else{
						self::$MaterialPurchaseItems->create($setData2);
						
						$rowData = self::$RawMaterials->where('id',$item['raw_material_id'])->first();
						$newQty = $rowData->current_stock+$item['qty'];
						self::$RawMaterials->where('id',$item['raw_material_id'])->update(['current_stock' => $newQty,'purchase_rate' => $item['rate']]);
					}
				}
			}
			
			return response()->json(['success'=>true, 'message' => 'Record updated successfully']);
		}
	}
}
