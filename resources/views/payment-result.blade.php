@extends('layouts.app')
@section('title', $success ? 'پرداخت موفق' : 'پرداخت ناموفق')
@section('content')
<main>
<section class="page-hero"><div class="shell"><div><div class="crumb">خانه ‹ نتیجه پرداخت</div><h1>{{ $success ? 'پرداخت با موفقیت انجام شد' : 'پرداخت تکمیل نشد' }}</h1><p>{{ $success ? 'سفارش شما ثبت و پرداخت آن تأیید شد.' : 'برای این سفارش پرداخت تأییدشده‌ای ثبت نشده است.' }}</p></div></div></section>
<section class="payment-wrap">
  <div class="shell">
    <div class="payment-result-card">
      <div class="payment-state {{ $success?'ok':'bad' }}">{{ $success?'✓':'×' }}</div>
      <h2>{{ $success ? 'سفارش با موفقیت ثبت شد' : 'پرداخت ناموفق بود' }}</h2>
      <p>{{ $success ? 'واحد فروش فولادینو سفارش را بررسی و برای هماهنگی تحویل با شما تماس می‌گیرد.' : 'می‌توانید مجدداً سفارش را ثبت کنید یا با واحد فروش تماس بگیرید.' }}</p>
      <div class="spec-table">
        <div><span>شماره سفارش</span><b>#{{ fa_digits($order->id) }}</b></div>
        <div><span>محصول</span><b>{{ $order->product?->name }}</b></div>
        <div><span>مقدار</span><b>{{ fa_digits($order->quantity_tons) }} تن</b></div>
        <div><span>مبلغ سفارش</span><b>{{ money_fa($order->total_toman) }} تومان</b></div>
        <div><span>وضعیت</span><b>{{ $success ? 'پرداخت‌شده' : 'ناموفق / لغوشده' }}</b></div>
      </div>
      <div class="order-actions" style="margin-top:16px">
        <a class="btn primary big" href="{{ route('products') }}">بازگشت به محصولات</a>
        <a class="btn outline big" href="{{ route('contact') }}">تماس با فروش</a>
      </div>
    </div>
  </div>
</section>
</main>
@endsection
