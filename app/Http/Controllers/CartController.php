<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::with('factory')->whereIn('id', array_keys($cart))->get()->keyBy('id');
        return view('cart', compact('cart', 'products'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate(['quantity_tons' => 'required|numeric|min:.01|max:10000']);
        abort_unless($product->is_active && $product->stock_status !== 'unavailable', 404);
        $cart = $request->session()->get('cart', []);
        $cart[$product->id] = round(($cart[$product->id] ?? 0) + (float) $data['quantity_tons'], 2);
        $request->session()->put('cart', $cart);
        return back()->with('success', 'محصول به سبد خرید اضافه شد.');
    }

    public function remove(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);
        return back()->with('success', 'محصول از سبد خرید حذف شد.');
    }
}
