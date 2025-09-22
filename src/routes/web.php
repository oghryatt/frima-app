<?php

use App\Models\User;
use App\Models\Item;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;


use App\Http\Controllers\MypageController;

use App\Http\Controllers\ProfileController;



use App\Http\Controllers\ItemController;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShoppingController;

use App\Http\Controllers\SellController;


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


Route::get('/register', [RegisterController::class, 'showForm'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');




Route::get('/login', [LoginController::class, 'showForm'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/mypage/profile', [ProfileController::class, 'show'])
    ->middleware('auth','verified')
    ->name('mypage.profile.show');

    Route::get('/mypage/profile/edit', [ProfileController::class, 'edit'])
    ->middleware('auth','verified')
    ->name('mypage.profile.edit');

Route::post('/mypage/profile/update', [ProfileController::class, 'update'])
    ->middleware('auth','verified')
    ->name('mypage.profile.update');

Route::get('/', [ItemController::class, 'index'])->name('items.index');


    Route::middleware('auth','verified')->group(function () {
        Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
        Route::get('/mypage/{id}', [MypageController::class, 'show'])->name('mypage.show');
    });
    






Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/mylist', [ItemController::class, 'mylist'])->middleware('auth','verified')->name('items.mylist');


Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');
Route::post('/item/{item_id}/like', [ItemController::class, 'toggleLike'])->middleware('auth','verified')->name('item.like');
Route::post('/item/{item_id}/comment', [ItemController::class, 'addComment'])->middleware('auth','verified')->name('item.comment');


Route::middleware('auth','verified')->group(function () {
    Route::get('/purchase/{item_id}', [OrderController::class, 'confirm'])->name('purchase.confirm');
    Route::post('/purchase/{item_id}', [OrderController::class, 'store'])->name('purchase.store');

    Route::get('/purchase/address/{item_id}', [ShoppingController::class, 'edit'])->name('purchase.address.edit');
    Route::post('/purchase/address/{item_id}', [ShoppingController::class, 'update'])->name('purchase.address.update');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/sell/create', [SellController::class, 'create'])->name('sell.create');
    Route::post('/sell/store', [SellController::class, 'store'])->name('sell.store');
});

Route::get('/mypage/buy', [MypageController::class, 'buy'])->middleware('auth','verified')->name('mypage.buy');

Route::get('/purchase/card/{item_id}', [PurchaseController::class, 'card'])->name('purchase.card');
Route::get('/stripe/success', [PurchaseController::class, 'success'])->name('stripe.success');
Route::get('/stripe/cancel', [PurchaseController::class, 'cancel'])->name('stripe.cancel');
