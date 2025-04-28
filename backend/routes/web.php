<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BuyRequestController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\MemberController;

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
Route::get('/user/show',[UserController::class,'show'])->name('user.show');
Route::get('/user/index',[UserController::class,'index'])->name('user.index');
Route::get('/events/create',[EventsController::class,'create'])->name('events.create');
Route::post('/events/store',[EventsController::class,'store'])->name('events.store');
Route::get('/events/index',[EventsController::class,'index'])->name('events.index');
Route::post('/member/store/{events}',[MemberController::class,'store'])->name('member.store');

