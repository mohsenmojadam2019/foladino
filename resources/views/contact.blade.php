@extends('layouts.app')
@section('title','تماس با ما')
@section('content')
<main>
<section class="page-hero"><div class="shell"><div><div class="crumb">خانه ‹ تماس با ما</div><h1>تماس با فولادینو</h1><p>برای خرید عمده، استعلام پروژه یا پیگیری سفارش با واحد فروش در ارتباط باشید.</p></div></div></section>

<section class="contact-wrap">
  <div class="shell contact-layout">
    <div class="contact-cards">
      <article><span>☎</span><div><small>واحد فروش</small><b>{{ $siteSettings['phone'] ?? '۰۲۱-۹۱۰۰۳۳۳۳' }}</b></div></article>
      <article><span>✉</span><div><small>ایمیل سازمانی</small><b>{{ $siteSettings['email'] ?? 'info@fooladino.ir' }}</b></div></article>
      <article><span>⌖</span><div><small>دفتر مرکزی</small><b>{{ $siteSettings['address'] ?? 'تهران، دفتر مرکزی فولادینو' }}</b></div></article>
      <article><span>◷</span><div><small>ساعات پاسخ‌گویی</small><b>شنبه تا چهارشنبه، ۸ تا ۱۷</b></div></article>
    </div>

    <div class="contact-form-card">
      <span class="eyebrow">درخواست تماس</span>
      <h2>پیامتان را برای واحد فروش بفرستید</h2>
      <p>برای استعلام دقیق‌تر، محصول، تناژ تقریبی و شهر مقصد را وارد کنید.</p>
      <form method="post" action="{{ route('quote.store') }}">
        @csrf
        <input type="hidden" name="note" value="فرم تماس سایت">
        <div class="form-grid">
          <label>نام / شرکت *<input name="name" required value="{{ old('name') }}"></label>
          <label>شماره تماس *<input name="mobile" required value="{{ old('mobile') }}"></label>
          <label>شهر مقصد<input name="city" value="{{ old('city') }}"></label>
          <label>موضوع<select name="product_name"><option>خرید عمده</option><option>پیگیری سفارش</option><option>همکاری سازمانی</option><option>سایر</option></select></label>
          <label class="full">توضیحات<textarea name="message" rows="3" placeholder="محصول و تناژ تقریبی موردنیاز را بنویسید"></textarea></label>
        </div>
        <button class="btn primary big" style="margin-top:10px">ارسال درخواست</button>
      </form>
    </div>
  </div>
</section>
</main>
@endsection
