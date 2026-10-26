<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RequiredParameters;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\AmcController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\MenuesController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\MaterialCategoryController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\EquipmentCategoryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\LogisticRangeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('api')->group(function () {
	
	Route::post('/yearwise-business/get',[ReportsController::class, 'getYearwiseBusiness'])->middleware(RequiredParameters::class);
	Route::post('/paid-unpaid',[ReportsController::class, 'getPaidUnpaid'])->middleware(RequiredParameters::class);
	
    #Customer Controller
	Route::any('/get/insta/posts',[CustomerController::class, 'test']);
	Route::get('/get/image/{max_width}/{max_height}/{image}',[CustomerController::class, 'createImage']);
    Route::post('/login',[CustomerController::class, 'login']);
	Route::get('/profile/get',[CustomerController::class, 'getProfile'])->middleware(RequiredParameters::class);
	Route::post('/profile/update',[CustomerController::class, 'updateProfile'])->middleware(RequiredParameters::class);
	Route::post('/password/update',[CustomerController::class, 'updatePassword'])->middleware(RequiredParameters::class);
	Route::post('/profile/pic/upload',[CustomerController::class, 'uploadProfilePic'])->middleware(RequiredParameters::class);

	#CategoryController
	Route::post('/category/create',[CategoryController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/category/list',[CategoryController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/category/get',[CategoryController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/category/update',[CategoryController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/category/list/all',[CategoryController::class, 'getListAll'])->middleware(RequiredParameters::class);
	Route::post('/subcategory/list/all',[CategoryController::class, 'getSubCateListAll'])->middleware(RequiredParameters::class);
	Route::put('/category/status/update/{id}/{status}',[CategoryController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	
	#EventTypeController
	Route::post('/event-type/create',[EventTypeController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/event-type/list',[EventTypeController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/event-type/get',[EventTypeController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/event-type/update',[EventTypeController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/event-type/list/all',[EventTypeController::class, 'getListAll'])->middleware(RequiredParameters::class);
	Route::put('/event-type/status/update/{id}/{status}',[EventTypeController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	
	#BookingController
	Route::post('/booking/create',[BookingController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/booking/list',[BookingController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/booking/get',[BookingController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/booking/update',[BookingController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/booking/list/all',[BookingController::class, 'getListAll'])->middleware(RequiredParameters::class);
	Route::put('/booking/status/update/{id}/{status}',[BookingController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	Route::post('/generate/booking/pdf',[BookingController::class, 'generatePdf'])->middleware(RequiredParameters::class);
	
	#PurchaseController
	Route::post('/purchase/create',[PurchaseController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/purchase/list',[PurchaseController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/purchase/get',[PurchaseController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/purchase/update',[PurchaseController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/purchase/list/all',[PurchaseController::class, 'getListAll'])->middleware(RequiredParameters::class);
	Route::put('/purchase/status/update/{id}/{status}',[PurchaseController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	
	#UnitController
	Route::post('/unit/create',[UnitController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/unit/list',[UnitController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/unit/get',[UnitController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/unit/update',[UnitController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/unit/list/all',[UnitController::class, 'getListAll'])->middleware(RequiredParameters::class);
	Route::put('/unit/status/update/{id}/{status}',[UnitController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	#RawMaterialController
	Route::post('/row-material/create',[RawMaterialController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/row-material/list',[RawMaterialController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/row-material/get',[RawMaterialController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/row-material/update',[RawMaterialController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/row-material/list/all',[RawMaterialController::class, 'getListAll'])->middleware(RequiredParameters::class);
	Route::put('/row-material/status/update/{id}/{status}',[RawMaterialController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	
	#EquipmentController
	Route::post('/equipments/create',[EquipmentController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/equipments/list',[EquipmentController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/equipments/get',[EquipmentController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/equipments/update',[EquipmentController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/equipments/list/all',[EquipmentController::class, 'getListAll'])->middleware(RequiredParameters::class);
	Route::put('/equipments/status/update/{id}/{status}',[EquipmentController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	
	#MaterialCategoryController
	Route::post('/material-category/create',[MaterialCategoryController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/material-category/list',[MaterialCategoryController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/material-category/get',[MaterialCategoryController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/material-category/update',[MaterialCategoryController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/material-category/list/all',[MaterialCategoryController::class, 'getListAll'])->middleware(RequiredParameters::class);
	Route::put('/material-category/status/update/{id}/{status}',[MaterialCategoryController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	
	#LogisticRangeController
	Route::post('/range/create',[LogisticRangeController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/range/list',[LogisticRangeController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/range/get',[LogisticRangeController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/range/update',[LogisticRangeController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/range/list/all',[LogisticRangeController::class, 'getListAll'])->middleware(RequiredParameters::class);
	Route::put('/range/status/update/{id}/{status}',[LogisticRangeController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	
	#EquipmentCategoryController
	Route::post('/equipment-category/create',[EquipmentCategoryController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/equipment-category/list',[EquipmentCategoryController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/equipment-category/get',[EquipmentCategoryController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/equipment-category/update',[EquipmentCategoryController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/equipment-category/list/all',[EquipmentCategoryController::class, 'getListAll'])->middleware(RequiredParameters::class);
	Route::put('/equipment-category/status/update/{id}/{status}',[EquipmentCategoryController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	
	#RolesController
	Route::post('/role/create',[RolesController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/role/list',[RolesController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/role/get',[RolesController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/role/update',[RolesController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/role/list/all',[RolesController::class, 'getListAll'])->middleware(RequiredParameters::class);
	Route::put('/role/status/update/{id}/{status}',[RolesController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	
	#ContactController
	Route::post('/customer/create',[ContactController::class, 'createContact'])->middleware(RequiredParameters::class);
	Route::post('/customer/list',[ContactController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/customer/get',[ContactController::class, 'getContact'])->middleware(RequiredParameters::class);
	Route::post('/customer/update',[ContactController::class, 'updateContact'])->middleware(RequiredParameters::class);
	Route::put('/customer/status/update/{id}/{status}',[ContactController::class, 'updateContactStatus'])->middleware(RequiredParameters::class);
	Route::post('/customer/list/all',[ContactController::class, 'getListAll'])->middleware(RequiredParameters::class);
	
	#ItemsController
	Route::post('/item/create',[ItemsController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/item/list',[ItemsController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/item/get',[ItemsController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/item/update',[ItemsController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/item/list/all',[ItemsController::class, 'getListAll'])->middleware(RequiredParameters::class);
	Route::put('/item/status/update/{id}/{status}',[ItemsController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	
	#MenuesController
	Route::post('/menu/create',[MenuesController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/menu/create/ai',[MenuesController::class, 'createByAi'])->middleware(RequiredParameters::class);
	Route::post('/menu/list',[MenuesController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/menu/get',[MenuesController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/menu/update',[MenuesController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/menu/list/all',[MenuesController::class, 'getListAll'])->middleware(RequiredParameters::class);
	Route::put('/menu/status/update/{id}/{status}',[MenuesController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	
	#LeadController
	Route::post('/lead/list',[LeadController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/lead/get',[LeadController::class, 'getData'])->middleware(RequiredParameters::class);
	
	#UserController
	Route::post('/user/create',[UserController::class, 'createUser'])->middleware(RequiredParameters::class);
	Route::post('/user/list',[UserController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/user/get',[UserController::class, 'getUser'])->middleware(RequiredParameters::class);
	Route::post('/user/update',[UserController::class, 'updateUser'])->middleware(RequiredParameters::class);
	Route::put('/user/status/update/{id}/{status}',[UserController::class, 'updateUserStatus'])->middleware(RequiredParameters::class);
	Route::post('/all/user/list',[UserController::class, 'getAllList'])->middleware(RequiredParameters::class);
	Route::post('/save/last/login/time',[UserController::class, 'saveLastLoginTime'])->middleware(RequiredParameters::class);
	Route::post('/check/login/time',[UserController::class, 'checkLoginTime'])->middleware(RequiredParameters::class);
	
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
