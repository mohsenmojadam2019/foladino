@extends('layouts.app')
@section('title','قیمت روز')
@section('content')
<main>
<section class="page-hero" style="--hero:url('{{ $siteSettings['hero_image'] ?? '/images/hero-steel.svg' }}')">
  <div class="shell"><div><span>خانه / قیمت روز</span><h1>جدول قیمت روز محصولات فولادی</h1><p>مشاهده قیمت‌های جاری محصولات فولادینو و تغییرات روزانه</p></div></div>
</section>

@php
  $avg = (int) round($products->avg('price'));
  $upCount = $products->where('price_change','>',0)->count();
  $downCount = $products->where('price_change','<',0)->count();
@endphp
<section class="section shell">
  <div class="market-summary">
    <article><span>امروز</span><b>{{ jdate_fa(now(),'l j F Y') }}</b><small>آخرین بروزرسانی {{ jdate_fa(now(),'H:i') }}</small></article>
    <article><span>میانگین قیمت هر کیلو</span><b>{{ money_fa($avg) }}</b><small>تومان</small></article>
    <article class="green"><span>محصولات صعودی</span><b>{{ fa_digits($upCount) }}</b><small>از {{ fa_digits($products->count()) }} محصول</small></article>
    <article class="red"><span>محصولات نزولی</span><b>{{ fa_digits($downCount) }}</b><small>از {{ fa_digits($products->count()) }} محصول</small></article>
  </div>

  <div class="price-dashboard">
    <aside class="chart-card">
      <div class="chart-head"><div><h3>روند قیمت میلگرد</h3><span>۳۰ روز اخیر</span></div><b>↗</b></div>
      <div class="fake-chart">
        <div class="chart-y"><span>۴۴,۰۰۰</span><span>۴۲,۰۰۰</span><span>۴۰,۰۰۰</span><span>۳۸,۰۰۰</span><span>۳۶,۰۰۰</span></div>
        <svg viewBox="0 0 440 230" preserveAspectRatio="none"><defs><linearGradient id="g" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#ff7618" stop-opacity=".35"/><stop offset="1" stop-color="#ff7618" stop-opacity="0"/></linearGradient></defs><path d="M0 180 L35 165 L70 172 L105 145 L140 155 L175 135 L210 142 L245 120 L280 112 L315 90 L350 82 L385 58 L440 42 L440 230 L0 230 Z" fill="url(#g)"/><polyline points="0,180 35,165 70,172 105,145 140,155 175,135 210,142 245,120 280,112 315,90 350,82 385,58 440,42" fill="none" stroke="#ff7618" stroke-width="4"/></svg>
      </div>
      <div class="chart-note">قیمت‌ها بر اساس آخرین بروزرسانی واحد فروش فولادینو نمایش داده می‌شوند.</div>
    </aside>

    <div class="prices-table-card">
      <div class="table-toolbar"><div><h2>قیمت محصولات</h2><span>تومان / واحد فروش</span></div><a class="btn primary" href="{{ route('bulk-order') }}">ثبت سفارش عمده</a></div>
      <div class="table-scroll">
        <table class="prices-table">
          <thead><tr><th>محصول</th><th>مشخصات</th><th>واحد</th><th>قیمت امروز</th><th>درصد تغییر</th><th>آخرین بروزرسانی</th><th></th></tr></thead>
          <tbody>
          @foreach($products as $p)
          <tr>
            <td><div class="table-product"><img src="{{ $p->image }}" alt=""><b>{{ $p->name }}</b></div></td>
            <td>{{ $p->size }} / {{ $p->standard }}</td><td>{{ $p->unit }}</td>
            <td><strong>{{ money_fa($p->price) }}</strong></td>
            <td><em class="{{ $p->price_change < 0 ? 'down' : 'up' }}">{{ $p->price_change > 0 ? '+' : '' }}{{ fa_digits($p->price_change) }}٪</em></td>
            <td>{{ jdate_fa(now()->subMinutes($loop->index*3),'H:i') }}</td>
            <td><a href="{{ route('bulk-order',['product'=>$p->slug]) }}">سفارش ←</a></td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<section class="price-cta"><div class="shell"><div><span>قیمت لحظه‌ای • تحویل سریع • مشاوره تخصصی</span><h2>سفارش عمده با قیمت روز</h2><p>برای پروژه‌های بزرگ از شرایط ویژه فروش سازمانی فولادینو استفاده کنید.</p></div><a class="btn primary big" href="{{ route('bulk-order') }}">ثبت سفارش عمده ←</a></div></section>
</main>
@endsection
