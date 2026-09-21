@extends('admin.layout')
@section('title','داشبورد')
@section('heading','سلام '.auth()->user()->name.' 👋')
@section('subheading','به پنل مدیریت فولادینو خوش آمدید.')
@section('content')
<div class="admin-kpis admin-kpis-v2">
  <article><span class="kpi-icon orange">◉</span><div><small>فروش کل</small><b>{{ money_fa($stats['revenue']) }}</b><em>تومان · سفارش‌های پرداخت‌شده</em></div></article>
  <article><span class="kpi-icon blue">🛒</span><div><small>کل سفارش‌ها</small><b>{{ fa_digits($stats['orders']) }}</b><em>{{ fa_digits($stats['pending_orders']) }} در انتظار پردازش</em></div></article>
  <article><span class="kpi-icon green">▦</span><div><small>محصولات فعال</small><b>{{ fa_digits($stats['products']) }}</b><em>{{ fa_digits($stats['factories']) }} کارخانه ثبت‌شده</em></div></article>
  <article><span class="kpi-icon purple">☏</span><div><small>استعلام‌های جدید</small><b>{{ fa_digits($stats['quotes_new']) }}</b><em>{{ fa_digits($stats['today_quotes']) }} مورد امروز</em></div></article>
</div>

<div class="admin-dashboard-grid">
  <section class="admin-card admin-chart-card">
    <div class="admin-card-head">
      <div><h3>روند سفارش‌ها</h3><p>نمای کلی فعالیت فروش در ماه جاری</p></div>
      <select class="admin-mini-select"><option>۳۰ روز اخیر</option><option>۷ روز اخیر</option></select>
    </div>
    <div class="admin-line-chart">
      <div class="chart-grid-lines"></div>
      <svg viewBox="0 0 620 230" preserveAspectRatio="none">
        <defs><linearGradient id="orderArea" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#ff7318" stop-opacity=".28"/><stop offset="1" stop-color="#ff7318" stop-opacity="0"/></linearGradient></defs>
        <path d="M0 188 L42 173 L84 177 L126 145 L168 128 L210 142 L252 150 L294 120 L336 126 L378 98 L420 106 L462 76 L504 88 L546 56 L588 66 L620 36 L620 230 L0 230 Z" fill="url(#orderArea)"/>
        <polyline points="0,188 42,173 84,177 126,145 168,128 210,142 252,150 294,120 336,126 378,98 420,106 462,76 504,88 546,56 588,66 620,36" fill="none" stroke="#ff7318" stroke-width="4"/>
      </svg>
      <div class="admin-chart-labels"><span>فروردین</span><span>اردیبهشت</span><span>خرداد</span><span>تیر</span><span>مرداد</span><span>شهریور</span></div>
    </div>
  </section>

  <section class="admin-card admin-status-card">
    <div class="admin-card-head"><div><h3>وضعیت سفارش‌ها</h3><p>ترکیب سفارش‌های ثبت‌شده</p></div></div>
    @php
      $totalOrders=max(1,$stats['orders']);
      $paidPct=round(($stats['paid_orders']/$totalOrders)*100);
      $pendingPct=round(($stats['pending_orders']/$totalOrders)*100);
      $otherPct=max(0,100-$paidPct-$pendingPct);
    @endphp
    <div class="admin-donut" style="--paid:{{$paidPct}};--pending:{{$pendingPct}}">
      <div><b>{{ fa_digits($stats['orders']) }}</b><small>مجموع سفارش‌ها</small></div>
    </div>
    <div class="status-legend">
      <span><i class="green"></i>پرداخت‌شده <b>{{ fa_digits($stats['paid_orders']) }}</b></span>
      <span><i class="blue"></i>در انتظار <b>{{ fa_digits($stats['pending_orders']) }}</b></span>
      <span><i class="orange"></i>سایر <b>{{ fa_digits(max(0,$stats['orders']-$stats['paid_orders']-$stats['pending_orders'])) }}</b></span>
    </div>
  </section>

  <section class="admin-card admin-stock-card">
    <div class="admin-card-head"><div><h3>محصولات اخیر</h3><p>آخرین تغییرات کاتالوگ</p></div><a href="{{ route('admin.catalog') }}">مشاهده همه</a></div>
    <div class="admin-product-mini-list">
      @foreach($products->take(5) as $p)
      <div><img src="{{ $p->image }}" alt=""><span><b>{{ $p->name }}</b><small>{{ $p->category?->name }}</small></span><em class="{{ $p->stock_status==='available'?'ok':'warn' }}">{{ $p->stock_status==='available'?'موجود':'استعلام' }}</em></div>
      @endforeach
    </div>
  </section>
</div>

<div class="admin-bottom-grid">
  <section class="admin-card">
    <div class="admin-card-head"><div><h3>آخرین سفارش‌ها</h3><p>پیگیری وضعیت پرداخت و ثبت</p></div><a href="{{ route('admin.orders') }}">مشاهده همه</a></div>
    <div class="admin-table-wrap">
      <table class="admin-table admin-orders-table">
        <thead><tr><th>#</th><th>مشتری</th><th>محصول</th><th>مبلغ</th><th>وضعیت</th><th>زمان</th></tr></thead>
        <tbody>
        @forelse($orders as $o)
        <tr>
          <td>#{{ fa_digits($o->id) }}</td>
          <td><b>{{ $o->customer_name }}</b><small>{{ $o->mobile }}</small></td>
          <td>{{ $o->product?->name ?? '—' }}</td>
          <td>{{ money_fa($o->total_toman) }}</td>
          <td><span class="status-badge {{ $o->status==='paid'?'won':($o->status==='failed'?'lost':'contacted') }}">{{ ['pending'=>'در انتظار','payment_started'=>'درگاه','paid'=>'پرداخت‌شده','failed'=>'ناموفق','cancelled'=>'لغوشده'][$o->status] ?? $o->status }}</span></td>
          <td>{{ jdate_fa($o->created_at,'m/d H:i') }}</td>
        </tr>
        @empty
        <tr><td colspan="6">سفارشی ثبت نشده است.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </section>

  <section class="admin-card admin-activity-card">
    <div class="admin-card-head"><div><h3>فعالیت‌های اخیر</h3><p>آخرین اتفاقات فروش و بازار</p></div></div>
    <div class="activity-list">
      @foreach($quotes->take(5) as $q)
      <div><i>☏</i><span><b>{{ $q->name }}</b><small>{{ $q->product_name ?: 'استعلام فروش' }}</small></span><time>{{ jdate_fa($q->created_at,'H:i') }}</time></div>
      @endforeach
      @foreach($products->take(2) as $p)
      <div><i>▦</i><span><b>قیمت {{ $p->name }} به‌روزرسانی شد</b><small>{{ money_fa($p->price) }} تومان</small></span><time>{{ jdate_fa($p->updated_at,'H:i') }}</time></div>
      @endforeach
    </div>
  </section>
</div>

<section class="admin-card admin-quick-v2">
  <a href="{{ route('admin.catalog') }}"><i>▦</i><span><b>افزودن محصول</b><small>مدیریت کاتالوگ</small></span></a>
  <a href="{{ route('admin.pricing') }}"><i>⌁</i><span><b>ثبت قیمت روز</b><small>به‌روزرسانی بازار</small></span></a>
  <a href="{{ route('admin.orders') }}"><i>🛒</i><span><b>مدیریت سفارش‌ها</b><small>پیگیری پرداخت</small></span></a>
  <a href="{{ route('admin.settings') }}"><i>⚙</i><span><b>تنظیمات</b><small>کاربران و سایت</small></span></a>
</section>
@endsection