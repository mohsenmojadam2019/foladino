<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderInvoiceMail;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function login(): View { return view('account.login'); }
    public function forgot(): View { return view('account.forgot'); }
    public function sendReset(Request $request): RedirectResponse { $request->validate(['email'=>'required|email']); Password::sendResetLink($request->only('email')); return back()->with('success','اگر ایمیل ثبت شده باشد، لینک بازیابی ارسال می‌شود.'); }
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate(['email'=>'required|email','password'=>'required|string']);
        if (!Auth::attempt($credentials, $request->boolean('remember'))) return back()->withErrors(['email'=>'اطلاعات ورود صحیح نیست.'])->withInput();
        $request->session()->regenerate(); return redirect()->intended(route('account.orders'));
    }
    public function register(): View { return view('account.register'); }
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name'=>'required|string|max:120','email'=>'required|email|unique:users,email','mobile'=>'required|string|max:20','password'=>'required|string|min:8|confirmed']);
        $user = User::create($data + ['password'=>Hash::make($data['password']), 'role'=>'customer', 'is_active'=>true]);
        Auth::login($user); return redirect()->route('account.orders');
    }
    public function logout(Request $request): RedirectResponse { Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect()->route('home'); }
    public function orders(): View { return view('account.orders', ['orders'=>PurchaseOrder::with('items')->where('user_id',Auth::id())->latest()->paginate(12)]); }
    public function order(PurchaseOrder $order): View { abort_unless($order->user_id === Auth::id(), 403); return view('account.order', ['order'=>$order->load(['items.product','transactions'])]); }
    public function cancel(PurchaseOrder $order): RedirectResponse { abort_unless($order->user_id === Auth::id(), 403); abort_unless(in_array($order->status,['pending','payment_started'],true), 422, 'این سفارش دیگر قابل لغو نیست.'); $order->update(['status'=>'cancelled']); return back()->with('success','سفارش لغو شد.'); }
    public function emailInvoice(PurchaseOrder $order): RedirectResponse { abort_unless($order->user_id === Auth::id(), 403); abort_unless(in_array($order->status,['paid','processing','ready','shipped','delivered'],true), 422); Mail::to(Auth::user()->email)->queue(new OrderInvoiceMail($order->load(['items','product.factory']))); return back()->with('success','فاکتور برای ایمیل شما ارسال شد.'); }
    public function profile(): View { return view('account.profile', ['user'=>Auth::user()]); }
    public function update(Request $request): RedirectResponse { $user=Auth::user(); $user->update($request->validate(['name'=>'required|string|max:120','mobile'=>'required|string|max:20','company_name'=>'nullable|string|max:180','national_id'=>'nullable|string|max:20','economic_code'=>'nullable|string|max:20','default_address'=>'nullable|string|max:1000'])); return back()->with('success','پروفایل به‌روزرسانی شد.'); }
}
