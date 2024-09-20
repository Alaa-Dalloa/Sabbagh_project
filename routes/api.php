<?php
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WholeSaleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BearenController;


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

Route::group([
 
    'middleware' => 'api',
    'prefix' => 'auth'
 
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/delete/{id}', [AuthController::class, 'delete']);
    Route::get('/allUser', [AuthController::class, 'index']);
    Route::post('/form', [WholeSaleController::class, 'create_form']);
    Route::get('/allform', [WholeSaleController::class, 'index']);
    Route::post('/updateStatusForm/{id}', [WholeSaleController::class, 'update']);



//Admin

  Route::post('/addManger', [AdminController::class, 'addManger'])->name('addManger');  
  Route::post('/addDelivary', [AdminController::class, 'addDelivary'])->name('addDelivary');  
  Route::get('/indexManger', [AdminController::class, 'indexManger']);
  Route::get('/indexDelivary', [AdminController::class, 'indexDelivary']);
  Route::post('/deleteMoD/{id}', [AdminController::class, 'deleteMoD']);
  Route::get('/searchMoD/{first_name}', [AdminController::class, 'searchMoD']);
  Route::post('/updatePower/{id}', [AdminController::class, 'update']);
  
//Rout of categories


Route::post("addcategories" , [CategoryController::class,'create']);
Route::get("allcategories" , [CategoryController::class,'index']);
Route::get("category/{id}" , [CategoryController::class,'show']);
Route::post("update/{id}" , [CategoryController::class,'update']);
Route::post("destroy/{id}" , [CategoryController::class,'delete']);
Route::get("search" , [CategoryController::class,'search']);


//Route of product

Route::post('/creatProduct', [ProductController::class, 'create']);
Route::get('/indexProduct', [ProductController::class, 'index']);
Route::get("searchProduct" , [ProductController::class,'search']);
Route::post("deleteProduct/{id}" , [ProductController::class,'delete']);
Route::post("editProduct/{id}" , [ProductController::class,'update']);
Route::get("productbycategory/{name}" , [ProductController::class,'showProductByCategory']);
Route::get("showProduct/{id}", [ProductController::class, 'show']);



//Route of Offer

Route::post('/creatOffer', [OfferController::class, 'create']);
Route::get('/indexOffer', [OfferController::class, 'index']);
Route::post("deleteOffer/{id}" , [OfferController::class,'delete']);
Route::post("editOffer/{id}" , [OfferController::class,'update']);


//package

Route::post("addPackage" , [PackageController::class,'addPackage']);
Route::get('/allOfferPackage', [PackageController::class, 'index']);
Route::get('/detailOfferPackage/{id}', [PackageController::class, 'DetailPackage']);
Route::post("deletePackage/{id}" , [PackageController::class,'delete']);
Route::post("editPackage/{id}" , [PackageController::class,'update']);


//order

Route::post("addOrder" , [OrderController::class,'create']);
Route::get('/allOrders', [OrderController::class, 'index']);
Route::get('/detailOrder/{id}', [OrderController::class, 'DetailOrder']);
Route::post("deleteOrder/{id}" , [OrderController::class,'delete']);
Route::get("myOrders" , [OrderController::class,'myOrders']);
Route::post('/updateStatusOrder/{id}', [OrderController::class, 'update']);


Route::get("mySales" , [OrderController::class,'mySales']);
Route::get("graph" , [BearenController::class,'bearen']);


});

