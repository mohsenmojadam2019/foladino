<?php
namespace App\Http\Controllers;
use App\Models\{Article,Category,Factory,Product,Testimonial};
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'categories'=>Category::where('is_active',true)->orderBy('sort_order')->take(5)->get(),
            'products'=>Product::with(['category','factory'])->where('is_active',true)->orderByDesc('is_featured')->take(6)->get(),
            'factories'=>Factory::where('is_active',true)->take(8)->get(),
            'articles'=>Article::where('is_published',true)->orderByDesc('published_at')->take(3)->get(),
            'testimonials'=>Testimonial::where('is_active',true)->take(2)->get(),
        ]);
    }
}
