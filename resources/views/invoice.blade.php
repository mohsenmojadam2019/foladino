@extends('layouts.app')
@section('title','فاکتور سفارش')
@section('content')
<main class="invoice-page"><div class="shell"><article class="invoice-card">
  <header><div><h1>فاکتور فروش فولادینو</h1><p>قیمت شفاف · تأمین مطمئن · تحویل سراسر کشور</p></div><strong>#{{ fa_digits($order->id) }}</strong></header>
  <div class="invoice-meta"><span>خریدار: <b>{{ $order->customer_name }}</b></span><span>موبایل: <b>{{ $order->mobile }}</b></span><span>شهر: <b>{{ $order->city ?: '—' }}</b></span></div>
  <table><thead><tr><th>محصول</th><th>کارخانه</th><th>مقدار</th><th>قیمت واحد</th><th>مبلغ کل</th></tr></thead><tbody><tr><td>{{ $order->product?->name }}</td><td>{{ $order->product?->factory?->name ?: '—' }}</td><td>{{ fa_digits($order->quantity_tons) }} تن</td><td>{{ money_fa($order->unit_price_toman) }}</td><td>{{ money_fa($order->total_toman) }}</td></tr></tbody></table>
  <footer><span>وضعیت: پرداخت‌شده</span><strong>مبلغ پرداختی: {{ money_fa($order->total_toman) }} تومان</strong></footer>
  <button onclick="window.print()">چاپ / ذخیره PDF</button>
</article></div></main>
<style>.invoice-page{padding:35px 0;background:#f5f8fb;min-height:65vh}.invoice-card{background:#fff;border:1px solid #dfe8f1;border-radius:16px;padding:28px;box-shadow:0 15px 35px #11335512}.invoice-card header,.invoice-meta,.invoice-card footer{display:flex;justify-content:space-between;gap:15px;align-items:center}.invoice-card h1{margin:0;color:#0b2b5d}.invoice-card p{color:#71829c}.invoice-meta{background:#f6faff;padding:14px;border-radius:10px;margin:22px 0}.invoice-card table{width:100%;border-collapse:collapse}.invoice-card th,.invoice-card td{padding:14px;border-bottom:1px solid #edf2f6;text-align:right}.invoice-card footer{padding:22px 0;font-size:16px}.invoice-card button{border:0;border-radius:8px;padding:11px 20px;background:#0d7df2;color:#fff}@media print{.topbar,.footer,.invoice-card button{display:none}.invoice-page{padding:0;background:#fff}.invoice-card{box-shadow:none;border:0}}</style>
@endsection
