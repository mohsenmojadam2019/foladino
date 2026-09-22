<?php

namespace App\Http\Controllers;

use App\Models\Factory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrustController extends Controller
{
    public function page(string $page): View
    {
        abort_unless(in_array($page, ['terms','privacy','returns','authenticity','licenses'], true), 404);
        return view('trust', ['page' => $page]);
    }

    public function compare(Request $request): View
    {
        $ids = collect($request->input('products', []))->map('intval')->filter()->unique()->take(4);
        $products = Product::with(['factory','category'])->whereIn('id', $ids)->get();
        $factories = Factory::whereIn('id', $products->pluck('factory_id')->filter())->get();
        return view('compare', compact('products','factories'));
    }
}
