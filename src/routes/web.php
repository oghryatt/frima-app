<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\ShoppingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\VerifyEmailController;
Route::get('/register', [RegisterController::class, 'showForm'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'showForm'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn () => view('mail'))->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

Route::get('/', [ItemController::class, 'index'])->name('items.index');

Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');

Route::middleware(['auth', 'verified', 'profile.set'])->group(function () {

    Route::get('/mypage/profile/setup', [ProfileController::class, 'setup'])->name('mypage.profile.setup');
    Route::post('/mypage/profile/setup', [ProfileController::class, 'storeSetup'])->name('mypage.profile.storeSetup');

    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
    Route::get('/mypage/{id}', [MypageController::class, 'show'])->name('mypage.show');
    Route::get('/mypage/buy', [MypageController::class, 'buy'])->name('mypage.buy');
    Route::get('/mylist', [ItemController::class, 'mylist'])->name('items.mylist');

    Route::get('/mypage/profile', [ProfileController::class, 'show'])->name('mypage.profile.show');
    Route::get('/mypage/profile/edit', [ProfileController::class, 'edit'])->name('mypage.profile.edit');
    Route::post('/mypage/profile/update', [ProfileController::class, 'update'])->name('mypage.profile.update');

    Route::post('/item/{item_id}/like', [ItemController::class, 'toggleLike'])->name('item.like');
    Route::post('/item/{item_id}/comment', [ItemController::class, 'addComment'])->name('item.comment');
    
    Route::get('/sell/create', [SellController::class, 'create'])->name('sell.create');
    Route::post('/sell/store', [SellController::class, 'store'])->name('sell.store');

    Route::get('/purchase/{item_id}', [OrderController::class, 'confirm'])->name('purchase.confirm');
    Route::post('/purchase/{item_id}', [OrderController::class, 'store'])->name('purchase.store');

    Route::get('/purchase/address/{item_id}', [ShoppingController::class, 'edit'])->name('purchase.address.edit');
    Route::post('/purchase/address/{item_id}', [ShoppingController::class, 'update'])->name('purchase.address.update');
    
    Route::get('/purchase/card/{item_id}', [PurchaseController::class, 'card'])->name('purchase.card');
    Route::get('/stripe/success', [PurchaseController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [PurchaseController::class, 'cancel'])->name('stripe.cancel');
});