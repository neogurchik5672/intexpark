<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BuyRequestController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CheckEventController;
use App\Http\Controllers\AdminController;

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

Route::get('/',[ProductController::class,'index']);
Route::post('/product/buy/{product}',[BuyRequestController::class,'buy'])->name('buyRequest.buy');
Route::get('/buy/index',[BuyRequestController::class,'index'])->name('buyRequest.index');
Route::get('/buy/{id}/show',[BuyRequestController::class,'show'])->name('buyRequest.show');
Route::post('/buy/create/{id}',[BuyRequestController::class,'create'])->name('buyRequest.create');
Route::get('/user/show',[UserController::class,'show'])->name('user.show');
Route::get('/user/index',[UserController::class,'index'])->name('user.index');
Route::get('/events/create',[EventsController::class,'create'])->name('events.create');
Route::post('/events/store',[EventsController::class,'store'])->name('events.store');
Route::get('/events/index',[EventsController::class,'index'])->name('events.index');
Route::post('/member/store/{events}',[MemberController::class,'store'])->name('member.store');
Route::get('/products/create',[ProductController::class,'create'])->name('product.create');
Route::post('/products/store',[ProductController::class,'store'])->name('product.store');
Route::post('/checkEvent/statusOff/{item}',[CheckEventController::class,'statusOff'])->name('checkEvent.statusOff');
Route::post('/checkEvent/statusOffNot/{item}',[CheckEventController::class,'statusOffNot'])->name('checkEvent.statusOffNot');
Route::get('/admin/index',[AdminController::class,'index'])->name('admin.index');
Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');

