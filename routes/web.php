<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\QRController;
use App\Http\Middleware\CheckTableNumber;
use App\Livewire\Pages\AllMenuPage;
use App\Livewire\Pages\CartPage;
use App\Livewire\Pages\CheckoutPage;
use App\Livewire\Pages\DetailPage;
use App\Livewire\Pages\FavoritePage;
use App\Livewire\Pages\PromoPage;
use App\Livewire\Pages\HomePage;
use App\Livewire\Pages\PaymentFailurePage;
use App\Livewire\Pages\PaymentSuccessPage;
use App\Livewire\Pages\ScanPage;
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;

Route::middleware(CheckTableNumber::class)->group(function(){
    // Beranda | Home
    Route::get('/', HomePage::class)->name('home');

    // Semua Menu | All Menu
    Route::get('/menu', AllMenuPage::class)->name('product.index');

    // Menu Favorit | Fovorite Food
    Route::get('/menu/favorite', FavoritePage::class)->name('product.favorite');

    // Menu promo | Today's Promo
    Route::get('/menu/promo', PromoPage::class)->name('product.promo');

    // Detail Menu | Menu Details
    Route::get('/menu/{id}', DetailPage::class)->name('product.detail');
});

Route::middleware(CheckTableNumber::class)->controller(TransactionController::class)->group(function(){
    Route::get('/cart', CartPage::class)->name('payment.cart');
    Route::get('/checkout', CheckoutPage::class)->name('payment.checkout');

    // Proses Pembayaran
    Route::middleware('throttle:10,1')->post('/payment', 'handlePayment')->name('payment');
    Route::get('/payment', function(){
        abort(404);
    });

    // Status Pembayaran
    Route::get('/payment/status/{id}', 'paymentStatus')->name('payment.status');
    Route::get('/payment/success', PaymentSuccessPage::class)->name('payment.success');
    Route::get('/payment/failure', PaymentFailurePage::class)->name('payment.failure');
});

// Webhook Update Pembayaran
Route::post('/payment/webhook', [TransactionController::class, 'handleWebhook'])->name('payment.webhook');

Route::controller(QRController::class)->group(function(){
    Route::post('/store-qr-result', 'storeResult')->name('product.scan.table');

    // Scanner
    Route::get('/scan', ScanPage::class)->name('product.scan');
    Route::get('/{tableNumber}', 'checkCode')->name('product.scan.table');
});