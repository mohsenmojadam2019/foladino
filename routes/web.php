<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/products', [HomeController::class,'products'])->name('products');
Route::get('/prices', [HomeController::class,'prices'])->name('prices');
Route::get('/bulk-order/{product:slug?}', [HomeController::class,'bulkOrder'])->name('bulk-order');
Route::get('/about', [HomeController::class,'about'])->name('about');
Route::get('/contact', [HomeController::class,'contact'])->name('contact');
Route::post('/quote', [QuoteController::class,'store'])->name('quote.store')->middleware('throttle:10,1');
Route::get('/cart', [CartController::class,'index'])->name('cart');
Route::post('/cart/{product}', [CartController::class,'add'])->name('cart.add');
Route::delete('/cart/{product}', [CartController::class,'remove'])->name('cart.remove');
Route::get('/checkout', fn () => redirect()->route('cart'))->name('checkout');
Route::post('/checkout', [CheckoutController::class,'start'])->name('checkout.start')->middleware('throttle:10,1');
Route::get('/payment/callback/{token}', [CheckoutController::class,'callback'])->name('payment.callback');
Route::get('/orders/{token}/invoice', [CheckoutController::class,'invoice'])->name('orders.invoice');

Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('/login',[AuthController::class,'showLogin'])->name('login');
    Route::post('/login',[AuthController::class,'login'])->name('login.submit')->middleware('throttle:10,1');
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');

    Route::middleware('admin')->group(function(){
        Route::get('/',[AdminController::class,'dashboard'])->name('dashboard');

        Route::middleware('role:super_admin,admin')->group(function(){
            Route::get('/catalog',[AdminController::class,'catalog'])->name('catalog');
            Route::post('/products',[AdminController::class,'productStore'])->name('products.store');
            Route::put('/products/{product}',[AdminController::class,'productUpdate'])->name('products.update');
            Route::delete('/products/{product}',[AdminController::class,'productDestroy'])->name('products.destroy');
            Route::post('/categories',[AdminController::class,'categoryStore'])->name('categories.store');
            Route::post('/factories',[AdminController::class,'factoryStore'])->name('factories.store');
        });

        Route::middleware('role:super_admin,admin,pricing')->group(function(){
            Route::get('/pricing',[AdminController::class,'pricing'])->name('pricing');
            Route::put('/pricing/{product}',[AdminController::class,'priceUpdate'])->name('pricing.update');
        });

        Route::middleware('role:super_admin,admin')->group(function(){
            Route::get('/orders',[AdminController::class,'orders'])->name('orders');
            Route::get('/quotes',[AdminController::class,'quotes'])->name('quotes');
            Route::put('/quotes/{quote}',[AdminController::class,'quoteUpdate'])->name('quotes.update');
        });

        Route::middleware('role:super_admin,admin,content')->group(function(){
            Route::get('/content',[AdminController::class,'content'])->name('content');
            Route::post('/articles',[AdminController::class,'articleStore'])->name('articles.store');
            Route::delete('/articles/{article}',[AdminController::class,'articleDestroy'])->name('articles.destroy');
        });

        Route::middleware('role:super_admin')->group(function(){
            Route::get('/settings',[AdminController::class,'settings'])->name('settings');
            Route::put('/settings',[AdminController::class,'settingsUpdate'])->name('settings.update');
            Route::post('/users',[AdminController::class,'userStore'])->name('users.store');
            Route::put('/users/{user}/toggle',[AdminController::class,'userToggle'])->name('users.toggle');
        });
    });
});
