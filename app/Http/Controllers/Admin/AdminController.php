<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Article,Category,Factory,PriceHistory,Product,PurchaseOrder,QuoteRequest,Setting,User,ShippingRate,PaymentTransaction};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard(){
        $hasOrders = Schema::hasTable('purchase_orders');
        $paidOrders = $hasOrders ? PurchaseOrder::where('status','paid') : null;
        $stats=[
            'products'=>Product::count(),
            'quotes_new'=>QuoteRequest::where('status','new')->count(),
            'factories'=>Factory::count(),
            'articles'=>Article::count(),
            'avg_price'=>(int) Product::avg('price'),
            'today_quotes'=>QuoteRequest::whereDate('created_at',today())->count(),
            'orders'=>$hasOrders ? PurchaseOrder::count() : 0,
            'paid_orders'=>$hasOrders ? (clone $paidOrders)->count() : 0,
            'pending_orders'=>$hasOrders ? PurchaseOrder::whereIn('status',['pending','payment_started'])->count() : 0,
            'revenue'=>$hasOrders ? (int) ((clone $paidOrders)->sum('total_toman')) : 0,
        ];
        return view('admin.dashboard',[
            'stats'=>$stats,
            'quotes'=>QuoteRequest::latest()->take(6)->get(),
            'products'=>Product::with(['factory','category'])->orderByDesc('updated_at')->take(6)->get(),
            'orders'=>$hasOrders ? PurchaseOrder::with('product')->latest()->take(6)->get() : collect(),
        ]);
    }

    public function catalog(){ return view('admin.catalog',['products'=>Product::with(['category','factory'])->latest()->get(),'categories'=>Category::orderBy('sort_order')->get(),'factories'=>Factory::orderBy('name')->get()]); }

    public function productStore(Request $r){
        $d=$r->validate(['name'=>'required|max:180','sku'=>'required|max:80|unique:products,sku','category_id'=>'required|exists:categories,id','factory_id'=>'nullable|exists:factories,id','size'=>'nullable|max:80','standard'=>'nullable|max:80','price'=>'required|integer|min:0','price_change'=>'nullable|numeric','stock_status'=>'required|in:available,call,unavailable','image'=>'nullable|max:255']);
        $d['slug']=Str::slug($r->input('slug') ?: $d['sku']); $d['unit']='کیلوگرم'; $d['is_featured']=$r->boolean('is_featured'); $d['is_active']=$r->boolean('is_active',true);
        Product::create($d); return back()->with('success','محصول ایجاد شد.');
    }
    public function productUpdate(Request $r, Product $product){
        $d=$r->validate(['name'=>'required|max:180','category_id'=>'required|exists:categories,id','factory_id'=>'nullable|exists:factories,id','size'=>'nullable|max:80','standard'=>'nullable|max:80','price'=>'required|integer|min:0','price_change'=>'nullable|numeric','stock_status'=>'required|in:available,call,unavailable']);
        $d['is_featured']=$r->boolean('is_featured'); $d['is_active']=$r->boolean('is_active'); $product->update($d); return back()->with('success','محصول به‌روزرسانی شد.');
    }
    public function productDestroy(Product $product){ $product->delete(); return back()->with('success','محصول حذف شد.'); }

    public function categoryStore(Request $r){ $d=$r->validate(['name'=>'required|max:120','slug'=>'required|max:120|unique:categories,slug','sort_order'=>'nullable|integer']); Category::create($d+['is_active'=>true]); return back()->with('success','دسته‌بندی ایجاد شد.'); }
    public function factoryStore(Request $r){ $d=$r->validate(['name'=>'required|max:160','slug'=>'required|max:160|unique:factories,slug','province'=>'nullable|max:80','city'=>'nullable|max:80']); Factory::create($d+['logo'=>'/images/factory.svg','is_active'=>true]); return back()->with('success','کارخانه ایجاد شد.'); }

    public function pricing(){ return view('admin.pricing',['products'=>Product::with(['factory','category'])->orderBy('name')->get()]); }
    public function priceUpdate(Request $r, Product $product){
        $d=$r->validate(['price'=>'required|integer|min:0','price_change'=>'required|numeric']);
        $product->update($d); PriceHistory::create(['product_id'=>$product->id,'price'=>$d['price'],'change_percent'=>$d['price_change'],'recorded_at'=>now()]);
        return back()->with('success','قیمت جدید ثبت شد.');
    }

    public function orders(){ return view('admin.orders',['orders'=>Schema::hasTable('purchase_orders') ? PurchaseOrder::with(['product','items'])->latest()->get() : collect()]); }
    public function transactions(){ return view('admin.transactions',['transactions'=>Schema::hasTable('payment_transactions') ? PaymentTransaction::with('order')->latest()->get() : collect()]); }
    public function customers(){ return view('admin.customers',['customers'=>User::where('role','customer')->latest()->get()]); }
    public function inventory(){ return view('admin.inventory',['products'=>Product::with(['factory','category'])->orderBy('name')->get()]); }
    public function permissions(){ return view('admin.permissions',['users'=>User::whereIn('role',['super_admin','admin','pricing','content'])->orderBy('name')->get()]); }
    public function shippingRates(){ return view('admin.shipping-rates',['rates'=>ShippingRate::latest()->get()]); }
    public function shippingRateStore(Request $r){$d=$r->validate(['origin_city'=>'required|max:80','destination_city'=>'required|max:80','min_weight_kg'=>'required|integer|min:0','max_weight_kg'=>'nullable|integer|gte:min_weight_kg','base_price_toman'=>'required|integer|min:0','price_per_kg_toman'=>'required|integer|min:0']); ShippingRate::create($d+['is_active'=>true]); return back()->with('success','نرخ حمل ثبت شد.');}
    public function shippingRateUpdate(Request $r, ShippingRate $shippingRate){$d=$r->validate(['origin_city'=>'required|max:80','destination_city'=>'required|max:80','min_weight_kg'=>'required|integer|min:0','max_weight_kg'=>'nullable|integer|gte:min_weight_kg','base_price_toman'=>'required|integer|min:0','price_per_kg_toman'=>'required|integer|min:0']);$shippingRate->update($d);return back()->with('success','نرخ حمل ویرایش شد.');}
    public function shippingRateToggle(ShippingRate $shippingRate){$shippingRate->update(['is_active'=>!$shippingRate->is_active]);return back()->with('success','وضعیت نرخ حمل تغییر کرد.');}
    public function shippingRateDestroy(ShippingRate $shippingRate){$shippingRate->delete();return back()->with('success','نرخ حمل حذف شد.');}
    public function orderUpdate(Request $r, PurchaseOrder $order){ $d=$r->validate(['status'=>'required|in:pending,payment_started,paid,processing,ready,shipped,delivered,cancelled,failed','admin_note'=>'nullable|string|max:1000']); $order->update($d); return back()->with('success','وضعیت سفارش به‌روزرسانی شد.'); }

    public function quotes(){ return view('admin.quotes',['quotes'=>QuoteRequest::latest()->get()]); }
    public function quoteUpdate(Request $r, QuoteRequest $quote){ $d=$r->validate(['status'=>'required|in:new,contacted,quoted,won,lost','note'=>'nullable|string|max:1000']); $quote->update($d); return back()->with('success','وضعیت استعلام به‌روزرسانی شد.'); }

    public function content(){ return view('admin.content',['articles'=>Article::orderByDesc('published_at')->get()]); }
    public function articleStore(Request $r){
        $d=$r->validate(['title'=>'required|max:220','excerpt'=>'nullable|max:500','body'=>'nullable|string','published_at'=>'nullable|string']);
        $d['slug']=Str::slug($r->input('slug') ?: uniqid('article-')); $d['image']=$r->input('image','/images/article-market.svg'); $d['is_published']=$r->boolean('is_published',true);
        $d['published_at']=jalali_to_carbon($r->input('published_at')) ?: now(); Article::create($d);
        return back()->with('success','مقاله منتشر شد.');
    }
    public function articleDestroy(Article $article){ $article->delete(); return back()->with('success','مقاله حذف شد.'); }

    public function settings(){ return view('admin.settings',['settings'=>Setting::pluck('value','key')->all(),'users'=>User::orderBy('name')->get()]); }
    public function settingsUpdate(Request $r){
        $keys=['site_name','phone','support_phone','email','address','hero_title','hero_subtitle','annual_tons','active_customers','factories_count','logo_image','hero_image','project_image','delivery_map_image','cta_image','factory_default_image','company_legal_name','company_registration_number','company_national_id','company_economic_code','company_tax_id','company_vat_percent'];
        foreach($r->only($keys) as $k=>$v) Setting::updateOrCreate(['key'=>$k],['value'=>$v,'group'=>'general']);
        return back()->with('success','تنظیمات ذخیره شد.');
    }
    public function userStore(Request $r){
        $d=$r->validate(['name'=>'required|max:120','email'=>'required|email|unique:users,email','password'=>'required|min:8','role'=>'required|in:super_admin,admin,pricing,content']);
        User::create(['name'=>$d['name'],'email'=>$d['email'],'password'=>Hash::make($d['password']),'role'=>$d['role'],'is_active'=>true]); return back()->with('success','کاربر سازمانی ایجاد شد.');
    }
    public function userToggle(User $user){ if($user->id===auth()->id()) return back()->with('error','نمی‌توانید حساب خودتان را غیرفعال کنید.'); $user->update(['is_active'=>!$user->is_active]); return back()->with('success','وضعیت کاربر تغییر کرد.'); }
}
