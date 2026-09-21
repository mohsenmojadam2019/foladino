@extends('layouts.app')
@section('title','تماس با ما')
@section('content')
<main>
<section class="page-hero" style="--hero:url('{{ $siteSettings['hero_image'] ?? '/images/hero-steel.svg' }}')"><div class="shell"><div><span>خانه / تماس با ما</span><h1>تماس با فولادینو</h1><p>برای خرید عمده، استعلام پروژه یا پیگیری سفارش با ما در ارتباط باشید.</p></div></div></section>
<section class="section shell contact-layout">
  <div class="contact-cards"><article><span>☎</span><div><small>واحد فروش</small><b>{{ $siteSettings['phone'] ?? '۰۲۱-۹۱۰۰۳۳۳۳' }}</b></div></article><article><span>✉</span><div><small>ایمیل سازمانی</small><b>{{ $siteSettings['email'] ?? 'info@fooladino.ir' }}</b></div></article><article><span>⌖</span><div><small>دفتر مرکزی</small><b>{{ $siteSettings['address'] ?? 'تهران، دفتر مرکزی فولادینو' }}</b></div></article><article><span>◷</span><div><small>ساعات پاسخ‌گویی</small><b>شنبه تا چهارشنبه ۸ تا ۱۷</b></div></article></div>
  <div class="contact-form-card"><span class="kicker">درخواست تماس</span><h2>پیامتان را برای واحد فروش بفرستید</h2><p>برای استعلام دقیق‌تر، نام محصول و تناژ تقریبی را ذکر کنید.</p><form method="post" action="{{ route('quote.store') }}">@csrf<input type="hidden" name="note" value="فرم تماس سایت"><div class="form-grid"><label>نام / شرکت *<input name="name" required></label><label>شماره تماس *<input name="mobile" required></label><label class="full">شهر<input name="city"></label><label class="full">موضوع<select name="product_name"><option>خرید عمده</option><option>پیگیری سفارش</option><option>همکاری سازمانی</option><option>سایر</option></select></label></div><button class="btn primary big">ارسال درخواست</button></form></div>
</section>
</main>
@endsection
