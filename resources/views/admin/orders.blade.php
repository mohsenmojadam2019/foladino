@extends('admin.layout')
@section('title','سفارش‌ها')
@section('heading','مدیریت سفارش‌ها')
@section('subheading','پیگیری سفارش‌های آنلاین، پرداخت و وضعیت مشتری')
@section('content')
@php
  $paid=$orders->where('status','paid');
  $pending=$orders->whereIn('status',['pending','payment_started']);
  $failed=$orders->whereIn('status',['failed','cancelled']);
  $revenue=(int)$paid->sum('total_toman');
@endphp

<div class="admin-page-kpis">
  <article><span>🛒</span><div><small>کل سفارش‌ها</small><b>{{ fa_digits($orders->count()) }}</b></div></article>
  <article><span>✓</span><div><small>پرداخت‌شده</small><b>{{ fa_digits($paid->count()) }}</b></div></article>
  <article><span>◷</span><div><small>در انتظار</small><b>{{ fa_digits($pending->count()) }}</b></div></article>
  <article><span>◉</span><div><small>فروش ثبت‌شده</small><b>{{ money_fa($revenue) }}</b></div></article>
</div>

<section class="admin-card">
  <div class="admin-card-head">
    <div><h3>فهرست سفارش‌ها</h3><p>{{ fa_digits($orders->count()) }} سفارش ثبت‌شده</p></div>
    <div class="admin-table-tools">
      <div class="admin-table-search"><span>⌕</span><input data-admin-table-search="#ordersTable" placeholder="جستجوی مشتری، موبایل یا محصول..."></div>
      <select data-admin-status-filter="#ordersTable"><option value="">همه وضعیت‌ها</option><option value="paid">پرداخت‌شده</option><option value="pending">در انتظار</option><option value="payment_started">ورود به درگاه</option><option value="failed">ناموفق</option><option value="cancelled">لغوشده</option></select>
    </div>
  </div>

  <div class="admin-table-wrap">
    <table class="admin-table admin-orders-full" id="ordersTable">
      <thead><tr><th>شماره</th><th>مشتری</th><th>محصول</th><th>مقدار</th><th>مبلغ</th><th>شهر</th><th>وضعیت</th><th>زمان ثبت</th></tr></thead>
      <tbody>
      @forelse($orders as $o)
      <tr data-status="{{ $o->status }}">
        <td><a href="{{ route('admin.orders.show',$o) }}"><strong>#{{ fa_digits($o->id) }}</strong></a></td>
        <td><div class="admin-customer-cell"><span class="mini-avatar">{{ mb_substr($o->customer_name,0,1) }}</span><div><b>{{ $o->customer_name }}</b><small>{{ $o->mobile }}</small></div></div></td>
        <td><div class="table-product">@if($o->product)<img src="{{ $o->product->image }}" alt="">@endif<span><b>{{ $o->product?->name ?? '—' }}</b><small>{{ $o->product?->standard }}</small></span></div></td>
        <td>{{ fa_digits($o->quantity_tons) }} تن</td>
        <td><strong>{{ money_fa($o->total_toman) }}</strong><small>تومان</small></td>
        <td>{{ $o->city ?: '—' }}</td>
        <td><form method="post" action="{{ route('admin.orders.update',$o) }}" class="inline-status">@csrf @method('put')<select name="status" onchange="this.form.submit()">@foreach(['pending'=>'در انتظار','payment_started'=>'درگاه پرداخت','paid'=>'پرداخت‌شده','processing'=>'در حال آماده‌سازی','ready'=>'آماده ارسال','shipped'=>'ارسال‌شده','delivered'=>'تحویل‌شده','failed'=>'ناموفق','cancelled'=>'لغوشده'] as $key=>$label)<option value="{{ $key }}" @selected($o->status===$key)>{{ $label }}</option>@endforeach</select></form></td>
        <td>{{ jdate_fa($o->created_at,'Y/m/d H:i') }}</td>
      </tr>
      @empty
      <tr><td colspan="8">هنوز سفارشی ثبت نشده است.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</section>

<div class="admin-order-summary">
  <section class="admin-card">
    <div class="admin-card-head"><div><h3>تقسیم وضعیت سفارش‌ها</h3><p>نمای سریع عملکرد پرداخت</p></div></div>
    <div class="order-status-bars">
      @php($total=max(1,$orders->count()))
      <div><span>پرداخت‌شده <b>{{ fa_digits($paid->count()) }}</b></span><i><em style="width:{{ round($paid->count()/$total*100) }}%"></em></i></div>
      <div><span>در انتظار <b>{{ fa_digits($pending->count()) }}</b></span><i><em class="pending" style="width:{{ round($pending->count()/$total*100) }}%"></em></i></div>
      <div><span>ناموفق / لغوشده <b>{{ fa_digits($failed->count()) }}</b></span><i><em class="failed" style="width:{{ round($failed->count()/$total*100) }}%"></em></i></div>
    </div>
  </section>
  <section class="admin-card">
    <div class="admin-card-head"><div><h3>میانگین سفارش</h3><p>بر اساس پرداخت‌های موفق</p></div></div>
    <div class="admin-big-number"><b>{{ $paid->count()?money_fa((int)round($revenue/$paid->count())):'۰' }}</b><span>تومان میانگین هر سفارش پرداخت‌شده</span></div>
  </section>
</div>
@endsection
