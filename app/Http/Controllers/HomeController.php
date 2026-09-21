<?php
namespace App\Http\Controllers;

use App\Models\{Article,Category,Product,Testimonial};
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    private function baseData(): array
    {
        return [
            'categories' => Category::where('is_active', true)->orderBy('sort_order')->get(),
            'featured' => Product::with(['category','prices'])
                ->where('is_active', true)->orderByDesc('is_featured')->take(6)->get(),
        ];
    }

    public function index(): View
    {
        return view('home', $this->baseData() + [
            'products' => Product::with(['category','prices'])
                ->where('is_active', true)->orderByDesc('is_featured')->take(6)->get(),
            'articles' => Article::where('is_published', true)->orderByDesc('published_at')->take(3)->get(),
            'testimonials' => Testimonial::where('is_active', true)->take(2)->get(),
        ]);
    }

    public function products(Request $request): View
    {
        $query = Product::with('category')->where('is_active', true);
        if ($request->filled('q')) {
            $q = trim((string) $request->string('q'));
            $query->where(fn($x) => $x->where('name','like',"%{$q}%")
                ->orWhere('sku','like',"%{$q}%")
                ->orWhere('standard','like',"%{$q}%")
                ->orWhere('size','like',"%{$q}%"));
        }
        if ($request->filled('category')) {
            $query->whereHas('category', fn($x) => $x->where('slug', $request->category));
        }
        if ($request->filled('stock')) {
            $query->where('stock_status', $request->stock);
        }

        return view('products', $this->baseData() + [
            'products' => $query->orderByDesc('is_featured')->paginate(8)->withQueryString(),
        ]);
    }

    public function prices(): View
    {
        return view('prices', $this->baseData() + [
            'products' => Product::with(['category','prices' => fn($q) => $q->latest('recorded_at')->take(8)])
                ->where('is_active', true)->get(),
        ]);
    }

    public function bulkOrder(?Product $product = null): View
    {
        $product ??= Product::with('category')->where('is_active', true)->firstOrFail();
        $products = Product::with('category')->where('is_active', true)->get();
        return view('bulk-order', $this->baseData() + compact('product','products'));
    }

    public function about(): View
    {
        return view('about', $this->baseData());
    }

    public function contact(): View
    {
        return view('contact', $this->baseData());
    }
}
