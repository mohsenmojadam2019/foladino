@extends('layouts.app')
@section('title','خانه')
@section('content')
<main>
<section class="hero" style="--hero:url('{{ $siteSettings['hero_image'] ?? '/images/hero-steel.svg' }}')">
  <div class="shell hero-inner">
    <div class="hero-copy">
      <span class="eyebrow">تولید و تأمین مستقیم از فولادینو</span>
      <h1>فروش عمده محصولات<br><span>تولیدی فولادینو</span></h1>
      <p>تأمین مستقیم، کیفیت پایدار و همکاری بلندمدت برای پروژه‌های بزرگ؛ بدون واسطه و با قیمت روز.</p>
      <div class="hero-actions">
        <a class="btn primary" href="{{ route('prices') }}">مشاهده قیمت روز</a>
        <a class="btn ghost" href="{{ route('bulk-order') }}">ثبت سفارش عمده</a>
      </div>
      <div class="hero-points">
        <span>▣ تولید و تأمین مستقیم</span>
        <span>◉ قیمت رقابتی</span>
        <span>▰ تحویل سراسر کشور</span>
      </div>
    </div>
    <aside class="hero-card">
      <small>خرید سازمانی</small>
      <h3>برای پروژه‌تان قیمت اختصاصی بگیرید</h3>
      <p>مقدار، محصول و مقصد را ثبت کنید؛ تیم فروش فولادینو برای پیش‌فاکتور نهایی با شما تماس می‌گیرد.</p>
      <a href="{{ route('bulk-order') }}">شروع سفارش ←</a>
    </aside>
  </div>
</section>

<section class="section shell">
  <div class="section-head">
    <div><span class="kicker">به‌روزرسانی روزانه</span><h2>قیمت روز محصولات فولادینو</h2><p>قیمت‌های فعلی برای سفارش‌های عمده و سازمانی</p></div>
    <a class="text-link" href="{{ route('prices') }}">مشاهده جدول کامل ←</a>
  </div>
  <div class="price-strip">
    @foreach($products->take(5) as $p)
    <a class="price-tile" href="{{ route('bulk-order',['product'=>$p->slug]) }}">
      <img src="{{ $p->image }}" alt="{{ $p->name }}">
      <div><b>{{ $p->category?->name ?? $p->name }}</b><strong>{{ money_fa($p->price) }}</strong><small>تومان / {{ $p->unit }}</small></div>
      <em class="{{ $p->price_change < 0 ? 'down' : 'up' }}">{{ $p->price_change > 0 ? '+' : '' }}{{ fa_digits($p->price_change) }}٪</em>
    </a>
    @endforeach
  </div>
</section>

<section class="section muted-section">
  <div class="shell">
    <div class="section-head centered"><div><span class="kicker">محصولات ما</span><h2>دسته‌بندی محصولات فولادی</h2><p>تمام کالاها، محصولات خود فولادینو و قابل سفارش عمده هستند.</p></div></div>
    <div class="category-grid">
      @foreach($categories as $cat)
      <a class="category-card" href="{{ route('products',['category'=>$cat->slug]) }}">
        <img src="{{ $cat->icon }}" alt="{{ $cat->name }}">
        <div><h3>{{ $cat->name }}</h3><p>مشاهده موجودی، مشخصات و قیمت روز</p><span>مشاهده محصولات ←</span></div>
      </a>
      @endforeach
    </div>
  </div>
</section>

<section class="section shell">
  <div class="split-title">
    <div><span class="kicker">فروش مستقیم</span><h2>محصولات منتخب امروز</h2></div>
    <a class="text-link" href="{{ route('products') }}">همه محصولات ←</a>
  </div>
  <div class="product-grid">
    @foreach($featured as $p)
    <article class="product-card">
      <div class="product-image"><img src="{{ $p->image }}" alt="{{ $p->name }}"><span class="stock {{ $p->stock_status }}">{{ $p->stock_status==='available' ? 'موجود' : ($p->stock_status==='call' ? 'تماس بگیرید' : 'ناموجود') }}</span></div>
      <div class="product-body">
        <small>{{ $p->category?->name }}</small><h3>{{ $p->name }}</h3>
        <div class="spec-row"><span>سایز: {{ $p->size }}</span><span>استاندارد: {{ $p->standard }}</span></div>
        <div class="product-price"><div><b>{{ money_fa($p->price) }}</b><small>تومان / {{ $p->unit }}</small></div><em class="{{ $p->price_change < 0 ? 'down' : 'up' }}">{{ fa_digits($p->price_change) }}٪</em></div>
        <a class="btn primary block" href="{{ route('bulk-order',['product'=>$p->slug]) }}">ثبت سفارش عمده</a>
      </div>
    </article>
    @endforeach
  </div>
</section>

<section class="section trust-section">
  <div class="shell trust-grid">
    <div class="trust-dark"><span class="shield">✓</span><h3>خرید مطمئن و مستقیم</h3><p>فاکتور رسمی، پرداخت امن و پیگیری سفارش از واحد فروش شرکت</p><a href="{{ route('about') }}">بیشتر درباره فولادینو</a></div>
    <div class="trust-items">
      <div><b>کیفیت تضمین‌شده</b><span>کنترل مشخصات فنی</span></div>
      <div><b>پرداخت امن</b><span>درگاه بانکی و پیش‌فاکتور</span></div>
      <div><b>ارسال کشوری</b><span>هماهنگی باربری پروژه</span></div>
      <div><b>پشتیبانی فروش</b><span>کارشناس اختصاصی سفارش</span></div>
    </div>
    <div class="support-box"><span>☎</span><h3>مشاوره سفارش عمده</h3><p>{{ $siteSettings['phone'] ?? '۰۲۱-۹۱۰۰۳۳۳۳' }}</p><a class="btn outline" href="{{ route('contact') }}">تماس با ما</a></div>
  </div>
</section>

<section class="section shell">
  <div class="section-head"><div><span class="kicker">راهنمای خرید</span><h2>از قیمت روز تا تحویل پروژه</h2></div></div>
  <div class="steps">
    <article><span>۱</span><h3>انتخاب محصول</h3><p>مشخصات و قیمت روز محصول موردنیاز را بررسی کنید.</p></article>
    <article><span>۲</span><h3>ثبت تناژ و مقصد</h3><p>مقدار سفارش و شهر مقصد را در فرم سفارش عمده وارد کنید.</p></article>
    <article><span>۳</span><h3>تأیید پیش‌فاکتور</h3><p>کارشناس فروش قیمت نهایی، حمل و زمان تحویل را تأیید می‌کند.</p></article>
    <article><span>۴</span><h3>پرداخت و ارسال</h3><p>پس از پرداخت، بار آماده و به مقصد پروژه ارسال می‌شود.</p></article>
  </div>
</section>

<section class="final-cta">
  <div class="shell">
    <div><span>برای خرید عمده آماده‌اید؟</span><h2>همین امروز سفارش پروژه خود را ثبت کنید</h2><p>قیمت روز، تأمین مستقیم و تحویل هماهنگ‌شده از فولادینو.</p></div>
    <a class="btn primary big" href="{{ route('bulk-order') }}">ثبت سفارش عمده ←</a>
  </div>
</section>
</main>
@endsection
