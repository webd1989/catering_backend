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
	
	Route::post('/user/create',[UserController::class, 'createUser'])->middleware(RequiredParameters::class);
	Route::post('/user/list',[UserController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/user/get',[UserController::class, 'getUser'])->middleware(RequiredParameters::class);
	Route::post('/user/update',[UserController::class, 'updateUser'])->middleware(RequiredParameters::class);
	Route::put('/user/status/update/{id}/{status}',[UserController::class, 'updateUserStatus'])->middleware(RequiredParameters::class);
	Route::post('/all/user/list',[UserController::class, 'getAllList'])->middleware(RequiredParameters::class);
	Route::post('/save/last/login/time',[UserController::class, 'saveLastLoginTime'])->middleware(RequiredParameters::class);
	Route::post('/check/login/time',[UserController::class, 'checkLoginTime'])->middleware(RequiredParameters::class);
	
	
	Route::post('/quotation/create',[QuotationController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/quotation/list',[QuotationController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/quotation/get',[QuotationController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/quotation/update',[QuotationController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/quotation/pdf/generate',[QuotationController::class, 'generatePdf'])->middleware(RequiredParameters::class);
	Route::put('/quotation/status/update/{id}/{status}',[QuotationController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	
	Route::post('/category/create',[CategoryController::class, 'create'])->middleware(RequiredParameters::class);
	Route::post('/category/list',[CategoryController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/category/get',[CategoryController::class, 'getData'])->middleware(RequiredParameters::class);
	Route::post('/category/update',[CategoryController::class, 'update'])->middleware(RequiredParameters::class);
	Route::post('/category/list/all',[CategoryController::class, 'getListAll'])->middleware(RequiredParameters::class);
	Route::put('/category/status/update/{id}/{status}',[CategoryController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	

	Route::post('/customer/create',[ContactController::class, 'createContact'])->middleware(RequiredParameters::class);
	Route::post('/customer/list',[ContactController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/customer/get',[ContactController::class, 'getContact'])->middleware(RequiredParameters::class);
	Route::post('/customer/update',[ContactController::class, 'updateContact'])->middleware(RequiredParameters::class);
	Route::put('/customer/status/update/{id}/{status}',[ContactController::class, 'updateContactStatus'])->middleware(RequiredParameters::class);
	Route::post('/customer/list/all',[ContactController::class, 'getListAll'])->middleware(RequiredParameters::class);
	
	Route::post('/project/create',[ProductsController::class, 'createProject'])->middleware(RequiredParameters::class);
	Route::post('/project/list',[ProductsController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/project/get',[ProductsController::class, 'getProject'])->middleware(RequiredParameters::class);
	Route::post('/project/update',[ProductsController::class, 'updateProject'])->middleware(RequiredParameters::class);
	Route::put('/project/status/update/{id}/{status}',[ProductsController::class, 'updateProjectStatus'])->middleware(RequiredParameters::class);
	
	Route::post('/amc/create',[AmcController::class, 'createRecord'])->middleware(RequiredParameters::class);
	Route::post('/amc/list',[AmcController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/amc/get',[AmcController::class, 'getRecord'])->middleware(RequiredParameters::class);
	Route::post('/amc/update',[AmcController::class, 'updateRecord'])->middleware(RequiredParameters::class);
	Route::put('/amc/status/update/{id}/{status}',[AmcController::class, 'updateRecordStatus'])->middleware(RequiredParameters::class);

	
	Route::post('/activity/create',[ActivityController::class, 'createActivity'])->middleware(RequiredParameters::class);
	Route::post('/activity/list',[ActivityController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/activity/get',[ActivityController::class, 'getActivity'])->middleware(RequiredParameters::class);
	Route::post('/activity/update',[ActivityController::class, 'updateActivity'])->middleware(RequiredParameters::class);
	Route::put('/activity/status/update/{id}/{status}',[ActivityController::class, 'updateActivityStatus'])->middleware(RequiredParameters::class);
	
	Route::post('/target/list',[InvoicesController::class, 'getList'])->middleware(RequiredParameters::class);
	Route::post('/invoice/create',[InvoicesController::class, 'createInvoice'])->middleware(RequiredParameters::class);
	Route::post('/bill-no/get',[InvoicesController::class, 'billNoGet'])->middleware(RequiredParameters::class);
	Route::post('/invoice/get',[InvoicesController::class, 'getInvoice'])->middleware(RequiredParameters::class);
	
	Route::post('/invoice/customers',[InvoicesController::class, 'getInvoiceCustomers'])->middleware(RequiredParameters::class);
	Route::post('/invoice/item/add',[InvoicesController::class, 'AddInvoiceItem'])->middleware(RequiredParameters::class);
	Route::put('/target/status/update/{id}/{status}',[InvoicesController::class, 'updateStatus'])->middleware(RequiredParameters::class);
	Route::post('/invoice/csv/generate',[InvoicesController::class, 'generateCsv'])->middleware(RequiredParameters::class);
	Route::post('/invoice/pdf/generate',[InvoicesController::class, 'generatePDF'])->middleware(RequiredParameters::class);
	Route::post('/payment/csv/generate',[InvoicesController::class, 'generatePaymentCSV'])->middleware(RequiredParameters::class);
	
	Route::post('/dashboard/report/get',[DashboardController::class, 'getDashboardReports'])->middleware(RequiredParameters::class);
	Route::post('/payment/update',[InvoicesController::class, 'updatePayment'])->middleware(RequiredParameters::class);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
