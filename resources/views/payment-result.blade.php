@extends('layouts.app')
@section('title', $success ? 'پرداخت موفق' : 'پرداخت ناموفق')
@section('content')
<main>
<section class="page-hero">
  <div class="shell"><div>
    <span>خانه / نتیجه پرداخت</span>
    <h1>{{ $success ? 'پرداخت با موفقیت انجام شد' : 'پرداخت تکمیل نشد' }}</h1>
    <p>{{ $success ? 'سفارش شما ثبت و پرداخت آن تأیید شد.' : 'برای این سفارش پرداخت تأییدشده‌ای ثبت نشده است.' }}</p>
  </div></div>
</section>
<section class="section shell">
  <div class="order-card" style="max-width:720px;margin:auto">
    <h3>جزئیات سفارش #{{ fa_digits($order->id) }}</h3>
    <div class="spec-table">
      <div><span>محصول</span><b>{{ $order->product?->name }}</b></div>
      <div><span>مقدار</span><b>{{ fa_digits($order->quantity_tons) }} تن</b></div>
      <div><span>مبلغ سفارش</span><b>{{ money_fa($order->total_toman) }} تومان</b></div>
      <div><span>وضعیت</span><b>{{ $success ? 'پرداخت‌شده' : 'ناموفق / لغوشده' }}</b></div>
    </div>
    <div class="order-actions" style="margin-top:24px">
      <a class="btn primary big" href="{{ route('products') }}">بازگشت به محصولات</a>
      <a class="btn outline big" href="{{ route('contact') }}">تماس با فروش</a>
    </div>
  </div>
</section>
</main>
@endsection
