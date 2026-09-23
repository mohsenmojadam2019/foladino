<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TrustController;
use App\Http\Controllers\AccountController;
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
Route::get('/checkout', function (\Illuminate\Http\Request $request) {
    $cart = $request->session()->get('cart', []);
    abort_if(!$cart, 302, '', ['Location' => route('cart')]);
    $products = \App\Models\Product::with('factory')->whereIn('id', array_keys($cart))->get()->keyBy('id');
    return view('checkout', compact('cart', 'products'));
})->name('checkout');
Route::get('/compare', [TrustController::class, 'compare'])->name('compare');
Route::get('/trust/{page}', [TrustController::class, 'page'])->name('trust.page');
Route::get('/account/login', [AccountController::class,'login'])->name('account.login');
Route::post('/account/login', [AccountController::class,'authenticate'])->name('account.login.submit');
Route::get('/account/forgot-password', [AccountController::class,'forgot'])->name('account.forgot');
Route::post('/account/forgot-password', [AccountController::class,'sendReset'])->name('account.forgot.submit');
Route::get('/account/register', [AccountController::class,'register'])->name('account.register');
Route::post('/account/register', [AccountController::class,'store'])->name('account.register.submit');
Route::middleware('auth')->prefix('account')->name('account.')->group(function(){ Route::post('/logout',[AccountController::class,'logout'])->name('logout'); Route::get('/orders',[AccountController::class,'orders'])->name('orders'); Route::get('/orders/{order}',[AccountController::class,'order'])->name('order'); Route::post('/orders/{order}/cancel',[AccountController::class,'cancel'])->name('order.cancel'); Route::post('/orders/{order}/email-invoice',[AccountController::class,'emailInvoice'])->name('order.email-invoice'); Route::get('/profile',[AccountController::class,'profile'])->name('profile'); Route::put('/profile',[AccountController::class,'update'])->name('profile.update'); });
Route::post('/checkout', [CheckoutController::class,'start'])->name('checkout.start')->middleware('throttle:10,1');
Route::get('/payment/callback/{token}', [CheckoutController::class,'callback'])->name('payment.callback');
Route::get('/orders/{token}/invoice', [CheckoutController::class,'invoice'])->name('orders.invoice');
Route::get('/orders/{token}/invoice.pdf', [CheckoutController::class,'invoicePdf'])->name('orders.invoice.pdf');

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
            Route::get('/transactions',[AdminController::class,'transactions'])->name('transactions');
            Route::get('/customers',[AdminController::class,'customers'])->name('customers');
            Route::get('/inventory',[AdminController::class,'inventory'])->name('inventory');
            Route::get('/shipping-rates',[AdminController::class,'shippingRates'])->name('shipping-rates');
            Route::put('/orders/{order}',[AdminController::class,'orderUpdate'])->name('orders.update');
            Route::post('/shipping-rates',[AdminController::class,'shippingRateStore'])->name('shipping-rates.store');
            Route::put('/shipping-rates/{shippingRate}',[AdminController::class,'shippingRateUpdate'])->name('shipping-rates.update');
            Route::post('/shipping-rates/{shippingRate}/toggle',[AdminController::class,'shippingRateToggle'])->name('shipping-rates.toggle');
            Route::delete('/shipping-rates/{shippingRate}',[AdminController::class,'shippingRateDestroy'])->name('shipping-rates.destroy');
            Route::get('/quotes',[AdminController::class,'quotes'])->name('quotes');
            Route::put('/quotes/{quote}',[AdminController::class,'quoteUpdate'])->name('quotes.update');
        });

        Route::middleware('role:super_admin,admin,content')->group(function(){
            Route::get('/content',[AdminController::class,'content'])->name('content');
            Route::post('/articles',[AdminController::class,'articleStore'])->name('articles.store');
            Route::delete('/articles/{article}',[AdminController::class,'articleDestroy'])->name('articles.destroy');
        });

        Route::middleware('role:super_admin')->group(function(){
            Route::get('/permissions',[AdminController::class,'permissions'])->name('permissions');
            Route::get('/settings',[AdminController::class,'settings'])->name('settings');
            Route::put('/settings',[AdminController::class,'settingsUpdate'])->name('settings.update');
            Route::post('/users',[AdminController::class,'userStore'])->name('users.store');
            Route::put('/users/{user}/toggle',[AdminController::class,'userToggle'])->name('users.toggle');
        });
    });
});
