@extends('layouts.app')
@section('title','خانه')
@section('content')
@php
  $priority = ['rebar','beam','sheet','pipe','profile','angle'];
  $priceProducts = collect($priority)->map(fn($slug) => $products->first(fn($p) => $p->category?->slug === $slug))->filter();
  $homeCategories = collect($priority)->map(fn($slug) => $categories->firstWhere('slug',$slug))->filter();
@endphp
<main>
<section class="home-hero">
  <div class="shell">
    <div class="hero-content">
      <span class="eyebrow">تولید و تأمین مستقیم فولادینو</span>
      <h1>فروش عمده محصولات<br>تولیدی فولادینو</h1>
      <p>تأمین مستقیم، کیفیت پایدار و همکاری بلندمدت برای پروژه‌های بزرگ؛ با قیمت روز و تحویل برنامه‌ریزی‌شده.</p>
      <div class="hero-actions">
        <a class="btn primary big" href="{{ route('prices') }}">▥ مشاهده قیمت روز</a>
        <a class="btn ghost big" href="{{ route('bulk-order') }}">🛒 ثبت سفارش عمده</a>
      </div>
      <div class="hero-benefits">
        <span>▣ تولید و تأمین مستقیم</span>
        <span>◉ قیمت رقابتی</span>
        <span>▤ تحویل سراسر کشور</span>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="section-title">
      <div><span class="eyebrow">به‌روزرسانی لحظه‌ای</span><h2>قیمت روز محصولات فولادی</h2><p>قیمت‌های ویژه خرید عمده و پروژه‌ای</p></div>
      <a class="text-link" href="{{ route('prices') }}">مشاهده همه قیمت‌ها ←</a>
    </div>
    <div class="home-price-grid">
      @foreach($priceProducts as $p)
      <a class="home-price-card" href="{{ route('bulk-order',['product'=>$p->slug]) }}">
        <img src="{{ $p->image }}" alt="{{ $p->name }}" loading="lazy">
        <div><b>{{ $p->category?->name }}</b><strong>{{ money_fa($p->price) }}</strong><small>تومان / {{ $p->unit }}</small></div>
        <em class="{{ $p->price_change < 0 ? 'down' : 'up' }}">{{ $p->price_change > 0 ? '+' : '' }}{{ fa_digits($p->price_change) }}٪</em>
      </a>
      @endforeach
    </div>
  </div>
</section>

<section class="section section-soft">
  <div class="shell">
    <div class="section-title">
      <div><h2>دسته‌بندی محصولات</h2></div>
      <a class="text-link" href="{{ route('products') }}">مشاهده همه محصولات ←</a>
    </div>
    <div class="home-category-grid">
      @foreach($homeCategories as $cat)
      <a class="home-category-card" href="{{ route('products',['category'=>$cat->slug]) }}">
        <div><h3>{{ $cat->name }}</h3><span>مشاهده محصولات ←</span></div>
        <img src="{{ $cat->icon }}" alt="{{ $cat->name }}" loading="lazy">
      </a>
      @endforeach
    </div>
  </div>
</section>

<section class="section">
  <div class="shell trust-strip">
    <div class="trust-dark">
      <span class="shield">✓</span>
      <div><h3>خرید مطمئن؛ با درگاه پرداخت امن</h3><p>پرداخت آنلاین سریع و امن ویژه مشتریان سازمانی</p><a class="btn ghost" href="{{ route('about') }}">اطلاعات بیشتر</a></div>
    </div>
    <div class="trust-logos">
      <h3>نمادها و مجوزهای اعتماد</h3>
      <div><span><i>◉</i>اتاق بازرگانی ایران</span><span><i>✓</i>استاندارد ایران</span><span><i>◆</i>وزارت صمت</span><span><i>✦</i>درگاه امن بانکی</span></div>
    </div>
    <div class="trust-support">
      <span>☏</span>
      <div><h3>مشاوره و ثبت سفارش عمده</h3><p>کارشناسان فروش آماده پاسخ‌گویی به درخواست‌های سازمانی هستند.</p><a class="btn outline" href="{{ route('contact') }}">تماس با ما ←</a></div>
    </div>
  </div>
</section>
</main>
@endsection
