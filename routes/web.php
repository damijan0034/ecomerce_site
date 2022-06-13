<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\Admin;
use Database\Seeders\ProductSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
//});

Route::get("/",[ProductController::class,'index'])->name('product.index');
Route::get("/product/{product:slug}",[ProductController::class,'show'])->name('show');
Route::get("search",[ProductController::class,'search'])->name('search');

Route::middleware(['auth'])->group(function(){
    Route::post("add_to_cart/{product:slug}",[ProductController::class,'addToCart'])->name('product.add_to_cart');
    Route::get('/cart_list',[ProductController::class,'cartList'])->name('product.cart_list');
    Route::delete('/cartdelete/{cart}',[ProductController::class,'cartDelete'])->name('cartdelete');
});

Route::middleware(['auth','admin'])->prefix('admin')->group( function ()
{
    Route::resource('/product',AdminController::class);
    Route::get('product/{product}',[AdminController::class,'show'])->name('product.show');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
