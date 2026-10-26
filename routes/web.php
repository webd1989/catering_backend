<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/',[PagesController::class, 'index'])->name('index');
Route::any('/about-us',[PagesController::class, 'aboutUs'])->name('aboutUs');
Route::any('/services',[PagesController::class, 'services'])->name('services');
Route::any('/contact-us',[PagesController::class, 'contactUs'])->name('contactUs');
Route::any('/gallery',[PagesController::class, 'gallery'])->name('gallery');

Route::any('/save-contact',[PagesController::class, 'saveContact'])->name('saveContact');


include('api.php');
