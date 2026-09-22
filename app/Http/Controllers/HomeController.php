<?php
namespace App\Http\Controllers;

use App\Models\{Article,Category,Factory,Product,Testimonial};
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    private function baseData(): array
    {
        return [
            'categories' => Category::where('is_active', true)->orderBy('sort_order')->get(),
            'factories' => Factory::where('is_active', true)->orderBy('name')->get(),
            'featured' => Product::with(['category','factory','prices'])
                ->where('is_active', true)->orderByDesc('is_featured')->take(6)->get(),
        ];
    }

    public function index(): View
    {
        return view('home', $this->baseData() + [
            'products' => Product::with(['category','factory','prices'])
                ->where('is_active', true)->orderByDesc('is_featured')->take(6)->get(),
            'articles' => Article::where('is_published', true)->orderByDesc('published_at')->take(3)->get(),
            'testimonials' => Testimonial::where('is_active', true)->take(2)->get(),
        ]);
    }

    public function products(Request $request): View
    {
        $query = Product::with(['category','factory'])->where('is_active', true);
        if ($request->filled('q')) {
            $q = trim((string) $request->string('q'));
            $query->where(fn($x) => $x->where('name','like',"%{$q}%")
                ->orWhere('sku','like',"%{$q}%")
                ->orWhere('standard','like',"%{$q}%")
                ->orWhere('size','like',"%{$q}%"));
        }
        // Support both the current slug filter and legacy category_id links.
        if ($request->filled('category_id')) {
            $query->where('category_id', (int) $request->input('category_id'));
        } elseif ($request->filled('category')) {
            $query->whereHas('category', fn($x) => $x->where('slug', $request->category));
        }
        if ($request->filled('stock')) {
            $query->where('stock_status', $request->stock);
        }
        if ($request->filled('factory')) {
            $query->whereHas('factory', fn($x) => $x->where('slug', $request->factory));
        }

        // Keep old catalog URLs working: order=inexpensive|expensive.
        $sort = (string) ($request->input('sort') ?: $request->input('order'));
        if (in_array($sort, ['price_asc', 'inexpensive'], true)) {
            $query->orderBy('price');
        } elseif (in_array($sort, ['price_desc', 'expensive'], true)) {
            $query->orderByDesc('price');
        } else {
            $query->orderByDesc('is_featured')->orderBy('name');
        }

        return view('products', $this->baseData() + [
            'products' => $query->paginate(8)->withQueryString(),
        ]);
    }

    public function prices(): View
    {
        return view('prices', $this->baseData() + [
            'products' => Product::with(['category','factory','prices' => fn($q) => $q->latest('recorded_at')->take(8)])
                ->where('is_active', true)->get(),
        ]);
    }

    public function bulkOrder(?Product $product = null): View
    {
        $product ??= Product::with(['category','factory'])->where('is_active', true)->firstOrFail();
        $product->loadMissing(['category','factory']);
        $products = Product::with(['category','factory'])->where('is_active', true)->get();
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
