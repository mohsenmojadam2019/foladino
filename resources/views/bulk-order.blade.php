@extends('layouts.app')
@section('title','سفارش عمده')
@section('content')
<main>
<section class="page-hero" style="--hero:url('{{ $siteSettings['hero_image'] ?? '/images/hero-steel.svg' }}')">
  <div class="shell"><div><span>خانه / سفارش عمده</span><h1>سفارش عمده</h1><p>تأمین مطمئن، قیمت رقابتی و تحویل به‌موقع برای پروژه شما</p></div></div>
</section>

<section class="section shell">
  <div class="order-top">
    <div class="order-gallery"><div class="main-product-image"><img src="{{ $product->image }}" alt="{{ $product->name }}"><span>کیفیت واقعی<br>برای پروژه‌های ماندگار</span></div><div class="thumbs"><img src="{{ $product->image }}"><img src="/images/coil.svg"><img src="/images/project.svg"></div></div>
    <div class="order-info">
      <span class="kicker">{{ $product->category?->name }}</span><h1>{{ $product->name }}</h1>
      <p>{{ $product->description }}</p>
      <div class="benefit-row"><span>✓ کیفیت تضمین‌شده</span><span>✓ تولید فولادینو</span><span>✓ تحویل سراسر کشور</span></div>
      <div class="spec-table"><div><span>نام محصول</span><b>{{ $product->name }}</b></div><div><span>سایز</span><b>{{ $product->size }}</b></div><div><span>استاندارد</span><b>{{ $product->standard }}</b></div><div><span>واحد فروش</span><b>تن / عمده</b></div><div><span>وضعیت</span><b>{{ $product->stock_status==='available' ? 'موجود' : 'استعلام' }}</b></div><div><span>تولیدکننده</span><b>فولادینو</b></div></div>
    </div>
  </div>

  <form method="post" action="{{ route('quote.store') }}" class="order-grid">
    @csrf
    <input type="hidden" name="product_name" value="{{ $product->name }}">
    <input type="hidden" name="note" value="ثبت از صفحه سفارش عمده">
    <div class="order-card">
      <h3>قیمت واحد (به‌روز)</h3><div class="unit-price"><strong>{{ money_fa($product->price) }}</strong><span>تومان / {{ $product->unit }}</span></div><small>آخرین بروزرسانی: {{ jdate_fa(now(),'Y/m/d - H:i') }}</small>
    </div>
    <div class="order-card">
      <h3>مقدار سفارش</h3><div class="qty-field"><input data-qty data-price="{{ $product->price }}" data-unit-factor="1000" data-total-target="#orderTotal" name="amount" type="number" min="1" step="1" value="25"><span>تن</span></div><small>حداقل سفارش پیشنهادی: ۵ تن</small>
    </div>
    <div class="order-card total-card"><h3>برآورد قیمت کل</h3><strong id="orderTotal">—</strong><small>مبلغ تقریبی است؛ قیمت حمل در پیش‌فاکتور نهایی اضافه می‌شود.</small></div>

    <div class="order-card shipping-card"><h3>روش ارسال</h3><label class="radio-row"><input type="radio" name="shipping_ui" checked disabled><span><b>باربری طرف قرارداد فولادینو</b><small>بیمه بار، هماهنگی و تحویل به مقصد</small></span></label><label class="radio-row"><input type="radio" disabled><span><b>تحویل درب کارخانه</b><small>مناسب خریداران دارای ناوگان</small></span></label><label class="radio-row"><input type="radio" disabled><span><b>حمل اختصاصی پروژه</b><small>با هماهنگی واحد لجستیک</small></span></label></div>

    <div class="order-card buyer-card"><h3>اطلاعات خریدار سازمانی</h3><div class="form-grid"><label>نام شرکت / خریدار *<input name="name" required value="{{ old('name') }}" placeholder="مثال: شرکت عمران سازه نوین"></label><label>شماره تماس *<input name="mobile" required value="{{ old('mobile') }}" placeholder="۰۹۱۲..."></label><label class="full">شهر مقصد<input name="city" value="{{ old('city') }}" placeholder="استان و شهر مقصد بار"></label></div><div class="order-actions"><button class="btn primary big">ثبت نهایی سفارش</button><a class="btn outline big" href="tel:02191003333">مشاوره تلفنی</a></div></div>

    <div class="order-card payment-card"><h3>روش پرداخت</h3><label class="radio-row selected"><input type="radio" checked disabled><span><b>پرداخت امن بانکی</b><small>پس از تأیید پیش‌فاکتور</small></span></label><label class="radio-row"><input type="radio" disabled><span><b>واریز به حساب شرکت</b><small>با دریافت فاکتور رسمی</small></span></label><div class="safe-pay"><span>✓</span><div><b>پرداخت امن و مطمئن</b><small>جزئیات پرداخت بعد از تأیید نهایی سفارش اعلام می‌شود.</small></div></div></div>
  </form>
</section>
</main>
@endsection
