@extends('layouts.app')
@section('title','خانه')
@section('body_class','home-v2-body')
@push('styles')
<link rel="stylesheet" href="/css/home-v2.css">
@endpush

@section('content')
@php
  $visuals = [
    'rebar' => '/images/home-ref/rebar.png',
    'beam' => '/images/home-ref/beam.png',
    'sheet' => '/images/home-ref/sheet.png',
    'profile' => '/images/home-ref/profile.png',
    'angle' => '/images/home-ref/angle.png',
    'pipe' => '/images/pipe.svg',
  ];
  $priority = ['rebar','beam','sheet','profile','angle'];
  $priceProducts = collect($priority)
    ->map(fn($slug) => $products->first(fn($p) => $p->category?->slug === $slug))
    ->filter();
  $homeCategories = collect($priority)
    ->map(fn($slug) => $categories->firstWhere('slug',$slug))
    ->filter();
@endphp

<main class="home-reference">
<section class="hero-ref">
  <div class="hero-sr">
    <h1>فروش عمده محصولات تولیدی فولادینو</h1>
    <p>تأمین مستقیم، کیفیت پایدار و همکاری بلندمدت برای پروژه‌های بزرگ با قیمت روز.</p>
  </div>
  <a class="hero-hotspot hero-hotspot-order" href="{{ route('bulk-order') }}" aria-label="ثبت سفارش عمده"></a>
  <a class="hero-hotspot hero-hotspot-price" href="{{ route('prices') }}" aria-label="مشاهده قیمت روز"></a>
  <div class="hero-mobile shell">
    <span>تولید و تأمین مستقیم</span>
    <h1>فروش عمده محصولات<br>تولیدی فولادینو</h1>
    <p>تأمین مستقیم، کیفیت پایدار و همکاری بلندمدت برای پروژه‌های بزرگ.</p>
    <div>
      <a class="btn primary" href="{{ route('prices') }}">مشاهده قیمت روز</a>
      <a class="btn ghost" href="{{ route('bulk-order') }}">ثبت سفارش عمده</a>
    </div>
  </div>
</section>

<section class="home-price-section">
  <div class="shell">
    <div class="home-section-heading price-heading">
      <div>
        <span>به‌روزرسانی لحظه‌ای</span>
        <h2>قیمت روز محصولات فولادی</h2>
        <p>قیمت‌های به‌روز ویژه خرید عمده و پروژه‌ای</p>
      </div>
      <a href="{{ route('prices') }}">مشاهده همه قیمت‌ها ←</a>
    </div>

    <div class="home-price-grid">
      @foreach($priceProducts as $p)
      <a class="home-price-card" href="{{ route('bulk-order',['product'=>$p->slug]) }}">
        <img src="{{ $visuals[$p->category?->slug] ?? $p->image }}" alt="{{ $p->name }}">
        <div class="price-copy">
          <b>{{ $p->category?->name }}</b>
          <strong>{{ money_fa($p->price) }}</strong>
          <small>تومان / {{ $p->unit }}</small>
        </div>
        <em class="{{ $p->price_change < 0 ? 'down' : 'up' }}">
          {{ $p->price_change > 0 ? '+' : '' }}{{ fa_digits($p->price_change) }}٪
        </em>
      </a>
      @endforeach
    </div>
  </div>
</section>

<section class="home-category-section">
  <div class="shell">
    <div class="home-section-heading category-heading">
      <div><h2>دسته‌بندی محصولات</h2></div>
      <a href="{{ route('products') }}">مشاهده همه محصولات ←</a>
    </div>
    <div class="home-category-grid">
      @foreach($homeCategories as $cat)
      <a class="home-category-card" href="{{ route('products',['category'=>$cat->slug]) }}">
        <img src="{{ $visuals[$cat->slug] ?? $cat->icon }}" alt="{{ $cat->name }}">
        <div>
          <h3>{{ $cat->name }}</h3>
          <span>مشاهده محصولات ←</span>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</section>

<section class="home-trust-section">
  <div class="shell trust-ref-grid">
    <div class="trust-pay">
      <span class="trust-shield">✓</span>
      <div>
        <h3>خرید مطمئن؛<br>با درگاه پرداخت امن</h3>
        <p>پرداخت آنلاین سریع و امن ویژه مشتریان سازمانی</p>
        <a href="{{ route('about') }}">اطلاعات بیشتر</a>
      </div>
    </div>

    <div class="trust-badges">
      <h3>نمادها و مجوزهای اعتماد</h3>
      <div>
        <span><i>◉</i><b>اتاق بازرگانی ایران</b></span>
        <span><i>✓</i><b>استاندارد ایران</b></span>
        <span><i>◆</i><b>وزارت صمت</b></span>
        <span><i>✦</i><b>درگاه امن بانکی</b></span>
      </div>
    </div>

    <div class="trust-support">
      <span class="support-icon">☏</span>
      <div>
        <h3>مشاوره و ثبت سفارش عمده</h3>
        <p>کارشناسان ما آماده پاسخگویی به درخواست‌های سازمانی شما هستند.</p>
        <a href="{{ route('contact') }}">تماس با ما ←</a>
      </div>
    </div>
  </div>
</section>
</main>
@endsection
