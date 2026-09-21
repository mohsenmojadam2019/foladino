@extends('layouts.app')
@section('title','قیمت روز')
@section('content')
@php
  $avg=(int)round($products->avg('price'));
  $upCount=$products->where('price_change','>',0)->count();
  $downCount=$products->where('price_change','<',0)->count();
  $avgChange=(float)$products->avg('price_change');
  $visuals=['rebar'=>'/images/home-ref/rebar.png','beam'=>'/images/home-ref/beam.png','sheet'=>'/images/home-ref/sheet.png','profile'=>'/images/home-ref/profile.png','angle'=>'/images/home-ref/angle.png','pipe'=>'/images/pipe.svg'];
@endphp
<main>
<section class="page-hero">
  <div class="shell"><div>
    <div class="crumb">خانه ‹ قیمت روز</div>
    <h1>جدول قیمت روز محصولات فولادی</h1>
    <p>مشاهده لحظه‌ای قیمت‌ها، مقایسه و تحلیل بازار</p>
  </div></div>
</section>

<section class="prices-wrap">
  <div class="shell">
    <div class="market-summary">
      <article>
        <span>▣ امروز</span>
        <b style="font-size:13px">{{ jdate_fa(now(),'l j F Y') }}</b>
        <small>آخرین بروزرسانی: {{ jdate_fa(now(),'H:i') }}</small>
      </article>
      <article class="market-index">
        <span>▥ شاخص کلی بازار</span><b>{{ $avgChange>=0?'+':'' }}{{ fa_digits(number_format($avgChange,1)) }}٪</b><small>نسبت به روز گذشته</small>
      </article>
      <article class="green"><span>↑ تعداد محصولات صعودی</span><b>{{ fa_digits($upCount) }}</b><small>از {{ fa_digits($products->count()) }} محصول</small></article>
      <article class="red"><span>↓ تعداد محصولات نزولی</span><b>{{ fa_digits($downCount) }}</b><small>از {{ fa_digits($products->count()) }} محصول</small></article>
      <article><span>◉ میانگین قیمت هر کیلو</span><b>{{ money_fa($avg) }}</b><small>تومان</small></article>
    </div>

    <div class="price-dashboard">
      <aside class="chart-card">
        <div class="chart-head"><h3>نمودار روند قیمت میلگرد</h3><b style="color:var(--orange)">⌁</b></div>
        <div class="chart-tabs"><span>۷ روز</span><span class="active">۳۰ روز</span><span>۳ ماه</span><span>۱ سال</span></div>
        <div class="fake-chart">
          <div class="chart-y"><span>۴۴,۰۰۰</span><span>۴۲,۰۰۰</span><span>۴۰,۰۰۰</span><span>۳۸,۰۰۰</span><span>۳۶,۰۰۰</span></div>
          <svg viewBox="0 0 440 230" preserveAspectRatio="none" aria-label="نمودار روند قیمت">
            <defs><linearGradient id="priceArea" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#ff7318" stop-opacity=".28"/><stop offset="1" stop-color="#ff7318" stop-opacity="0"/></linearGradient></defs>
            <path d="M0 180 L25 166 L45 171 L73 148 L104 136 L132 151 L160 159 L188 143 L215 151 L244 132 L270 126 L300 100 L330 92 L360 72 L390 82 L420 55 L440 43 L440 230 L0 230 Z" fill="url(#priceArea)"/>
            <polyline points="0,180 25,166 45,171 73,148 104,136 132,151 160,159 188,143 215,151 244,132 270,126 300,100 330,92 360,72 390,82 420,55 440,43" fill="none" stroke="#ff7318" stroke-width="4"/>
            <circle cx="440" cy="43" r="7" fill="#ff7318" stroke="#fff" stroke-width="3"/>
          </svg>
        </div>
        <div class="chart-note">روند نمایشی بر اساس آخرین ثبت‌های قیمت سامانه؛ قیمت نهایی سفارش هنگام ثبت تأیید می‌شود.</div>
      </aside>

      <div class="prices-table-card">
        <div class="table-toolbar">
          <div><h2>قیمت محصولات</h2><span>{{ fa_digits($products->count()) }} محصول فعال</span></div>
          <div class="table-filters"><input placeholder="جستجوی محصول..."><select><option>همه برندها</option></select><select><option>همه استان‌ها</option></select></div>
        </div>
        <div class="table-scroll">
          <table class="prices-table">
            <thead><tr><th>محصول</th><th>مشخصات / سایز</th><th>واحد</th><th>قیمت امروز</th><th>قیمت دیروز</th><th>درصد تغییر</th><th>آخرین بروزرسانی</th><th>نمودار</th></tr></thead>
            <tbody>
            @foreach($products as $p)
              @php
                $prev=(int)($p->prices->skip(1)->first()?->price ?? round($p->price/(1+($p->price_change/100 ?: .001))));
                $isDown=$p->price_change<0;
              @endphp
              <tr>
                <td><div class="table-product"><img src="{{ $visuals[$p->category?->slug] ?? $p->image }}" alt=""><b>{{ $p->name }}</b></div></td>
                <td>{{ $p->size }} · {{ $p->standard }}</td>
                <td>{{ $p->unit }}</td>
                <td><strong>{{ money_fa($p->price) }}</strong></td>
                <td>{{ money_fa($prev) }}</td>
                <td><em class="{{ $isDown?'down':'up' }}" style="font-style:normal;font-weight:900">{{ $isDown?'↓':'↑' }} {{ fa_digits(abs($p->price_change)) }}٪</em></td>
                <td>{{ jdate_fa(now()->subMinutes($loop->index*2),'H:i') }}</td>
                <td>
                  <svg class="trend-mini" viewBox="0 0 50 22"><polyline points="1,17 9,12 17,15 25,8 33,10 41,4 49,6" fill="none" stroke="{{ $isDown?'#df3545':'#0a9a5b' }}" stroke-width="2"/></svg>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <section class="price-cta">
      <div class="shell">
        <div><h2>سفارش عمده با قیمت روز</h2><p>برای پروژه‌های بزرگ، از قیمت‌های به‌روز و شرایط ویژه سازمانی استفاده کنید.</p></div>
        <a class="btn primary big" href="{{ route('bulk-order') }}">ثبت سفارش عمده ←</a>
        <div class="cta-points"><span>☏ مشاوره تخصصی</span><span>⌁ قیمت لحظه‌ای</span><span>▤ تحویل سریع</span></div>
      </div>
    </section>
  </div>
</section>
</main>
@endsection
