@extends('admin.layout')
@section('title','مدیریت قیمت‌ها')
@section('heading','مدیریت قیمت روز')
@section('subheading','ثبت سریع قیمت، درصد تغییر و پایش روند بازار')
@section('actions')
<a class="btn btn-primary" href="#priceTable">+ ثبت قیمت‌های جدید</a>
@endsection
@section('content')
@php
  $avg=(int)round($products->avg('price'));
  $up=$products->where('price_change','>',0)->count();
  $down=$products->where('price_change','<',0)->count();
  $latest=$products->sortByDesc('updated_at')->first();
@endphp

<div class="admin-page-kpis">
  <article><span>◉</span><div><small>میانگین قیمت</small><b>{{ money_fa($avg) }}</b></div></article>
  <article><span>↑</span><div><small>محصولات صعودی</small><b>{{ fa_digits($up) }}</b></div></article>
  <article><span>↓</span><div><small>محصولات نزولی</small><b>{{ fa_digits($down) }}</b></div></article>
  <article><span>◷</span><div><small>آخرین بروزرسانی</small><b>{{ $latest ? jdate_fa($latest->updated_at,'H:i') : '—' }}</b></div></article>
</div>

<div class="admin-pricing-grid">
  <section class="admin-card">
    <div class="admin-card-head">
      <div><h3>روند کلی قیمت‌ها</h3><p>نمای تحلیلی تغییرات اخیر بازار</p></div>
      <select class="admin-mini-select"><option>۳۰ روز اخیر</option><option>۷ روز اخیر</option><option>۳ ماه اخیر</option></select>
    </div>
    <div class="admin-line-chart pricing-chart">
      <div class="chart-grid-lines"></div>
      <svg viewBox="0 0 620 230" preserveAspectRatio="none">
        <defs><linearGradient id="marketArea" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#ff7318" stop-opacity=".28"/><stop offset="1" stop-color="#ff7318" stop-opacity="0"/></linearGradient></defs>
        <path d="M0 175 L45 162 L90 169 L135 145 L180 132 L225 140 L270 116 L315 123 L360 97 L405 88 L450 100 L495 72 L540 66 L585 45 L620 38 L620 230 L0 230 Z" fill="url(#marketArea)"/>
        <polyline points="0,175 45,162 90,169 135,145 180,132 225,140 270,116 315,123 360,97 405,88 450,100 495,72 540,66 585,45 620,38" fill="none" stroke="#ff7318" stroke-width="4"/>
      </svg>
      <div class="admin-chart-labels"><span>ابتدای ماه</span><span>هفته اول</span><span>هفته دوم</span><span>هفته سوم</span><span>امروز</span></div>
    </div>
  </section>

  <section class="admin-card">
    <div class="admin-card-head"><div><h3>تغییرات بازار</h3><p>محصولات با بیشترین نوسان</p></div></div>
    <div class="admin-price-movers">
      @foreach($products->sortByDesc(fn($p)=>abs($p->price_change))->take(6) as $p)
      <div>
        <img src="{{ $p->image }}" alt="">
        <span><b>{{ $p->name }}</b><small>{{ $p->factory?->name ?? 'فولادینو' }}</small></span>
        <strong>{{ money_fa($p->price) }}</strong>
        <em class="{{ $p->price_change<0?'neg':'pos' }}">{{ $p->price_change>0?'+':'' }}{{ fa_digits($p->price_change) }}٪</em>
      </div>
      @endforeach
    </div>
  </section>
</div>

<section class="admin-card" id="priceTable" style="margin-top:10px">
  <div class="admin-card-head">
    <div><h3>لیست قیمت جاری</h3><p>ویرایش سریع قیمت و ثبت در تاریخچه بازار</p></div>
    <div class="admin-table-search"><span>⌕</span><input data-admin-table-search="#pricingTable" placeholder="جستجوی محصول یا کارخانه..."></div>
  </div>

  <div class="admin-table-wrap">
    <table class="admin-table admin-pricing-table" id="pricingTable">
      <thead><tr><th>محصول</th><th>کارخانه</th><th>قیمت فعلی</th><th>تغییر</th><th>آخرین ویرایش</th><th>ثبت قیمت جدید</th></tr></thead>
      <tbody>
      @foreach($products as $p)
      <tr>
        <td><div class="table-product"><img src="{{ $p->image }}" alt=""><span><b>{{ $p->name }}</b><small>{{ $p->size }} · {{ $p->standard }}</small></span></div></td>
        <td>{{ $p->factory?->name ?? 'فولادینو' }}</td>
        <td><strong>{{ money_fa($p->price) }}</strong><small>تومان / {{ $p->unit }}</small></td>
        <td><span class="price-change-pill {{ $p->price_change<0?'negative':'positive' }}">{{ $p->price_change<0?'↓':'↑' }} {{ fa_digits(abs($p->price_change)) }}٪</span></td>
        <td>{{ jdate_fa($p->updated_at,'Y/m/d H:i') }}</td>
        <td>
          <form class="inline-price inline-price-v2" method="post" action="{{ route('admin.pricing.update',$p) }}">
            @csrf @method('PUT')
            <label><span>قیمت</span><input name="price" type="number" value="{{ $p->price }}"></label>
            <label><span>٪ تغییر</span><input name="price_change" type="number" step="0.01" value="{{ $p->price_change }}"></label>
            <button class="btn btn-primary btn-sm">ثبت</button>
          </form>
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</section>
@endsection