@extends('layouts.app')
@section('content')
<main id="top">
<section class="hero">
  <div class="container hero-grid">
    <aside class="market-card">
      <div class="card-head"><h3>نمای کلی بازار آهن‌آلات <i class="live-dot"></i></h3><a href="#prices">مشاهده همه</a></div>
      @foreach($products->take(5) as $p)
      <div class="market-row"><div class="spark {{ $p->price_change < 0 ? 'down' : '' }}"><span></span><span></span><span></span><span></span><span></span></div><b>{{ $p->category->name }}</b><span>{{ money_fa($p->price) }}</span><em class="{{ $p->price_change < 0 ? 'neg' : 'pos' }}">{{ $p->price_change > 0 ? '+' : '' }}{{ fa_digits($p->price_change) }}٪</em></div>
      @endforeach
      <small>آخرین بروزرسانی: {{ jdate_fa(now(),'Y/m/d H:i') }}</small>
    </aside>
    <div class="hero-copy">
      <div class="eyebrow">قیمت شفاف <span>·</span> تأمین مطمئن <span>·</span> تحویل سراسر کشور</div>
      <h1>بازار هوشمند<br><span>خرید آهن‌آلات</span></h1>
      <p>{{ $siteSettings['hero_subtitle'] ?? 'فولادینو؛ پلی میان پروژه‌های بزرگ امروز و آینده‌ای محکم‌تر' }}</p>
      <div class="hero-actions"><a class="btn btn-primary btn-lg" href="#quote">دریافت استعلام سریع ←</a><a class="btn btn-ghost btn-lg" href="#prices">مشاهده قیمت‌ها</a></div>
      <div class="hero-stats"><div><b>{{ $siteSettings['factories_count'] ?? '۵۰۰+' }}</b><span>کارخانه معتبر</span></div><div><b>{{ $siteSettings['active_customers'] ?? '۱۰,۰۰۰+' }}</b><span>مشتری فعال</span></div><div><b>{{ $siteSettings['annual_tons'] ?? '۱۰۰,۰۰۰+' }}</b><span>تن تأمین سالانه</span></div></div>
    </div>
    <div class="hero-visual"><img src="/images/hero-steel.svg" alt="انبار و تأمین فولاد"><div class="hero-badge">مطمئن‌تر<br>سریع‌تر<br><strong>هوشمندتر</strong></div></div>
  </div>
</section>

<section id="products" class="container category-strip">
 @foreach($categories as $cat)
 <a class="category-card" href="#prices"><div><h3>{{ $cat->name }}</h3><p>{{ match($cat->slug){'rebar'=>'میلگرد آجدار و ساده در سایزهای مختلف','beam'=>'انواع IPE، IPN و هاش','sheet'=>'ورق گرم، سرد و گالوانیزه','pipe'=>'لوله‌های صنعتی و ساختمانی','profile'=>'پروفیل ساختمانی و صنعتی',default=>'مقاطع فولادی متنوع'} }}</p></div><img src="{{ $cat->icon }}" alt="{{ $cat->name }}"><span>←</span></a>
 @endforeach
</section>

<section class="container feature-grid" id="services">
 <div class="quote-card" id="quote"><div class="section-title"><div><h2>استعلام هوشمند قیمت</h2><p>در چند ثانیه، قیمت روز را از معتبرترین کارخانه‌ها دریافت کنید.</p></div><span class="ai-orb">AI</span></div>
  <form method="post" action="{{ route('quote.store') }}" class="quote-form">@csrf
    <input name="name" required placeholder="نام و نام خانوادگی"><input name="mobile" required placeholder="شماره تماس">
    <select name="product_name"><option value="">نوع محصول</option>@foreach($categories as $c)<option>{{ $c->name }}</option>@endforeach</select>
    <input name="amount" type="number" min="0" step="0.1" placeholder="مقدار (تن)"><input name="city" placeholder="شهر مقصد"><button class="btn btn-primary">دریافت استعلام ←</button>
  </form>
 </div>
 <div class="project-card"><img src="/images/project.svg" alt="پروژه عمرانی"><div><h2>تأمین برای پروژه‌های عمرانی</h2><p>از ساختمان‌های مسکونی تا پروژه‌های ملی، فولادینو همراه مطمئن شماست.</p><a href="#quote" class="btn btn-light">مشاهده راهکارهای سازمانی</a></div></div>
 <div class="delivery-card"><div><h2>پوشش ارسال به سراسر ایران</h2><p>تحویل سریع و مطمئن در همه استان‌ها</p><ul><li>ناوگان معتبر</li><li>تحویل در محل پروژه</li><li>پیگیری آنلاین سفارش</li></ul></div><img src="/images/iran-map.svg" alt="ارسال به سراسر ایران"></div>
</section>

<section id="prices" class="container data-grid">
 <div class="prices-panel">
   <div class="card-head"><div><h2>آخرین بروزرسانی قیمت‌ها</h2><small>{{ jdate_fa(now(),'Y/m/d H:i') }}</small></div><a href="#quote">استعلام خرید</a></div>
   <div class="price-table-wrap"><table><thead><tr><th>محصول</th><th>کارخانه</th><th>سایز</th><th>قیمت (تومان/کیلو)</th><th>تغییر</th><th>وضعیت</th></tr></thead><tbody>
   @foreach($products as $p)<tr><td><img src="{{ $p->image }}"><b>{{ $p->name }}</b></td><td>{{ $p->factory?->name ?? '—' }}</td><td>{{ $p->size }}</td><td>{{ money_fa($p->price) }}</td><td class="{{ $p->price_change < 0 ? 'neg' : 'pos' }}">{{ $p->price_change>0?'+':'' }}{{ fa_digits($p->price_change) }}٪</td><td><span class="status-dot"></span> موجود</td></tr>@endforeach
   </tbody></table></div>
 </div>
 <div class="smart-panel"><div class="section-title"><div><h2>پیشنهاد هوشمند فولادینو</h2><p>ترکیب قیمت، موجودی و فاصله حمل برای انتخاب بهتر.</p></div><span class="ai-tag">AI</span></div><div class="supplier-cards">
 @foreach($products->take(3) as $p)<article><small>{{ $p->factory?->name }}</small><span class="chip">{{ $loop->first ? 'بهترین قیمت' : ($loop->index===1 ? 'تعادل قیمت و کیفیت' : 'تحویل سریع') }}</span><b>{{ money_fa($p->price) }}</b><em>تومان/کیلو</em><a href="#quote" class="btn btn-outline">انتخاب</a></article>@endforeach
 </div></div>
 <div class="testimonial-panel"><div class="card-head"><h2>تجربه مشتریان ما</h2><a href="#">مشاهده همه</a></div>@foreach($testimonials as $t)<blockquote>«{{ $t->quote }}»<footer><img src="{{ $t->avatar }}"><span><b>{{ $t->name }}</b><small>{{ $t->role }}</small></span></footer></blockquote>@endforeach<div class="mini-stats"><div><b>۹۵٪+</b><span>رضایت مشتریان</span></div><div><b>۳,۰۰۰+</b><span>پروژه موفق</span></div><div><b>۵+ سال</b><span>همراهی مطمئن</span></div></div></div>
</section>

<section id="factories" class="container factories"><div class="section-title"><div><h2>برخی از کارخانه‌های همکار ما</h2><p>شبکه گسترده تأمین برای انتخاب بهینه قیمت و محل بارگیری</p></div><a href="#quote">دریافت لیست قیمت</a></div><div class="factory-row">@foreach($factories as $f)<div><img src="{{ $f->logo }}"><span>{{ $f->name }}</span></div>@endforeach</div></section>

<section id="articles" class="container articles"><div class="section-title"><div><h2>تحلیل بازار و راهنمای خرید</h2><p>محتوای کاربردی برای تصمیم‌گیری حرفه‌ای در بازار فولاد</p></div><a href="#">مشاهده همه مقالات</a></div><div class="article-grid">@foreach($articles as $a)<article><img src="{{ $a->image }}" alt="{{ $a->title }}"><div><span>{{ jdate_fa($a->published_at,'Y/m/d') }}</span><h3>{{ $a->title }}</h3><p>{{ $a->excerpt }}</p><a href="#">ادامه مطلب ←</a></div></article>@endforeach</div></section>

<section class="final-cta"><div class="container"><img src="/images/coil.svg" alt="کلاف فولادی"><div><h2>برای پروژه بعدی خود، <span>هوشمندتر</span> تأمین کنید</h2><p>با فولادینو خرید آهن‌آلات ساده‌تر، سریع‌تر و مطمئن‌تر است.</p></div><a href="#quote" class="btn btn-primary btn-lg">همین حالا استعلام بگیرید ←</a><div class="cta-features"><span>◉ قیمت شفاف</span><span>▣ تحویل مطمئن</span><span>◎ پشتیبانی تخصصی</span></div></div></section>
</main>
@endsection
