<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BuyRequestController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CheckEventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AchievementController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\TelegramController;
use Illuminate\Support\Carbon;

Auth::routes();

Route::get('/auth/telegram/token/{token}', function ($token) {
    $user = User::where('login_token', $token)
                ->where('login_token_expires_at', '>', now())
                ->first();

    if (!$user) {
        return response('Вход не выполнен. Токен недействителен или истёк.', 403);
    }

    Auth::login($user);

    // // Очищаем токен после успешной авторизации
    // $user->update([
    //     'login_token' => null,
    //     'login_token_expires_at' => null
    // ]);

    return redirect('/');
});
// Route::match(['POST', 'GET'],'/', [TelegramLoginController::class, 'login']);
Route::get('/',[ProductController::class,'index']);
Route::middleware(['auth'])->group(function () {
Route::post('/user/remove/{id}',[UserController::class,'remove'])->name('user.remove');
   
// Route::get('/index',[ProductController::class,'index']); Для авторизации
Route::post('/product/buy/{product}',[BuyRequestController::class,'buy'])->name('buyRequest.buy');
Route::get('/buy/index',[BuyRequestController::class,'index'])->name('buyRequest.index');
Route::get('/buy/show/{id}',[BuyRequestController::class,'show'])->name('buyRequest.show');
Route::post('/buy/create/{id}',[BuyRequestController::class,'create'])->name('buyRequest.create');
Route::get('/user/show',[UserController::class,'show'])->name('user.show');
Route::get('/events/index',[EventsController::class,'index'])->name('events.index');
Route::post('/member/store/{events}',[MemberController::class,'store'])->name('member.store');
Route::post('/checkEvent/statusOff/{item}',[CheckEventController::class,'statusOff'])->name('checkEvent.statusOff');
Route::post('/checkEvent/statusOffNot/{item}',[CheckEventController::class,'statusOffNot'])->name('checkEvent.statusOffNot');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/index', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/destroy/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::match(['PUT', 'GET'],'/user/updateCoins/{id}', [UserController::class, 'updateCoins'])->name('user.updateCoins');
// Route::match(['PUT', 'GET'],'/user/updateCoin/{id}', [UserController::class, 'updateCoin'])->name('user.updateCoin');
Route::get('/user/all/{id}',[UserController::class,'all'])->name('user.all');


Route::post('/user/addAvatar/{$id}',[UserController::class,'all'])->name('user.addAvatar');
// Админка
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('achievements', AchievementController::class)->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]);
});
// Страница ачивок
Route::get('/achievements', function () {
    $achievements = \App\Models\Achievement::all();
    $user = auth()->user(); // или получить пользователя как-то иначе
    return view('achievements.index', compact('achievements', 'user'));
});
//Страницы пользователя(+редактирование)
Route::get('/user/account',[UserController::class,'account'])->name('user.account');
Route::get('/user/user_view/{id}',[UserController::class,'user_view'])->name('user.user_view')->middleware('role:admin');
Route::get('/user/user_editing/{id}',[UserController::class,'user_editing'])->name('user.user_editing')->middleware('role:admin');
//Обновление данных пользователя (для админа)
Route::post('/user/update-user-data', [UserController::class, 'updateUserData'])->name('user.update-user-data')->middleware('role:admin');
//Удаление пользователя 
Route::post('/user/delete-user', [UserController::class, 'deleteUser'])->name('user.delete-user')->middleware('role:admin');

Route::get('/admin/index',[AdminController::class,'index'])->name('admin.index')->middleware('role:admin');
Route::get('/admin/products',[AdminController::class,'products'])->name('admin.products')->middleware('role:admin');
Route::get('/admin/transaction',[AdminController::class,'transaction'])->name('admin.transaction')->middleware('role:admin');
Route::put('/admin/newAdmin/{id}',[AdminController::class,'newAdmin'])->name('admin.newAdmin')->middleware('role:admin');
Route::get('/events/create',[EventsController::class,'create'])->name('events.create')->middleware('role:admin');
Route::post('/events/store',[EventsController::class,'store'])->name('events.store')->middleware('role:admin');
Route::get('/user/index',[UserController::class,'index'])->name('user.index')->middleware('role:admin');
Route::get('/products/create',[ProductController::class,'create'])->name('product.create')->middleware('role:admin');
Route::post('/products/store',[ProductController::class,'store'])->name('product.store')->middleware('role:admin');
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit')->middleware('role:admin');
Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update')->middleware('role:admin');
Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('role:admin');
});
