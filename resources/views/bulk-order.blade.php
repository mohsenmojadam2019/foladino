@extends('layouts.app')
@section('title','سفارش عمده')
@section('content')
@php
  $visuals=['rebar'=>'/images/home-ref/rebar.png','beam'=>'/images/home-ref/beam.png','sheet'=>'/images/home-ref/sheet.png','profile'=>'/images/home-ref/profile.png','angle'=>'/images/home-ref/angle.png','pipe'=>'/images/pipe.svg'];
  $mainImage=$visuals[$product->category?->slug] ?? $product->image;
@endphp
<main>
<section class="page-hero">
  <div class="shell"><div>
    <div class="crumb">خانه ‹ سفارش عمده ‹ {{ $product->name }}</div>
    <h1>سفارش عمده</h1>
    <p>تأمین مطمئن، قیمت رقابتی و تحویل به‌موقع</p>
  </div></div>
</section>

<section class="order-wrap">
  <div class="shell">
    <div class="order-top">
      <section class="order-gallery">
        <div class="main-product-image">
          <img src="{{ $mainImage }}" alt="{{ $product->name }}">
          <span class="image-note">کیفیت واقعی، پروژه‌های ماندگار</span>
        </div>
        <div class="thumbs">
          <img src="{{ $mainImage }}" alt="">
          <img src="/images/rebar.svg" alt="">
          <img src="/images/coil.svg" alt="">
          <img src="/images/project.svg" alt="">
        </div>
      </section>

      <section class="order-specs">
        <h3>⚙ مشخصات فنی محصول</h3>
        <div class="spec-table">
          <div><span>نام محصول</span><b>{{ $product->name }}</b></div>
          <div><span>سایز</span><b>{{ $product->size ?: 'استاندارد' }}</b></div>
          <div><span>استاندارد</span><b>{{ $product->standard ?: 'ملی' }}</b></div>
          <div><span>گرید</span><b>{{ $product->standard ?: 'صنعتی' }}</b></div>
          <div><span>واحد فروش</span><b>تن</b></div>
          <div><span>محل تولید</span><b>{{ $product->factory?->name ?? 'فولادینو' }}</b></div>
        </div>
        <div class="total-card order-card" style="margin-top:9px">
          <h3>▦ برآورد قیمت کل</h3>
          <strong id="orderTotal">—</strong>
          <small>قیمت تقریبی بر اساس مقدار سفارش و قیمت روز محاسبه می‌شود.</small>
        </div>
      </section>

      <section class="order-info">
        <span class="kicker">{{ $product->category?->name }}</span>
        <h1>{{ $product->name }}</h1>
        <p>{{ $product->description }}</p>
        <div class="benefit-row">
          <span>کیفیت تضمین‌شده</span><span>قیمت رقابتی</span>
          <span>تحویل سراسر کشور</span><span>موجودی پایدار</span>
        </div>
      </section>
    </div>

    <form method="post" action="{{ route('checkout.start') }}">
      @csrf
      <input type="hidden" name="product_id" value="{{ $product->id }}">
      <input type="hidden" name="product_name" value="{{ $product->name }}">
      <input type="hidden" name="note" value="ثبت از صفحه سفارش عمده جدید">

      <div class="order-metrics">
        <div class="order-card">
          <h3>▥ قیمت واحد (به‌روز)</h3>
          <div class="unit-price"><strong>{{ money_fa($product->price) }}</strong><span>تومان / {{ $product->unit }}</span></div>
          <small>آخرین بروزرسانی: {{ jdate_fa(now(),'Y/m/d - H:i') }}</small>
        </div>

        <div class="order-card">
          <h3>⚖ مقدار سفارش</h3>
          <div class="qty-field"><input data-qty data-price="{{ $product->price }}" data-unit-factor="1000" data-total-target="#orderTotal" name="amount" type="number" min="1" step="1" value="{{ old('amount',25) }}"><span>تن</span></div>
          <small>حداقل سفارش پیشنهادی: ۵ تن</small>
        </div>

        <div class="order-card">
          <h3>وضعیت فروش</h3>
          <span class="badge {{ $product->stock_status==='available'?'green':'amber' }}">{{ $product->stock_status==='available'?'● موجود در انبار':'● نیازمند استعلام' }}</span>
          <p style="font-size:8px;color:var(--muted);margin:8px 0 0">زمان تحویل براساس مقصد و برنامه بارگیری نهایی می‌شود.</p>
        </div>
      </div>

      <div class="order-form-grid">
        <section class="order-card shipping-card">
          <h3>▤ روش ارسال</h3>
          <label class="radio-row selected"><input type="radio" name="shipping_ui" value="contract" checked><span><b>ارسال با باربری طرف قرارداد فولادینو</b><small>تحویل به سراسر کشور · بیمه بار · رهگیری</small></span></label>
          <label class="radio-row"><input type="radio" name="shipping_ui" value="factory"><span><b>تحویل درب کارخانه</b><small>مخصوص مشتریان عمده دارای ناوگان</small></span></label>
          <label class="radio-row"><input type="radio" name="shipping_ui" value="special"><span><b>حمل اختصاصی</b><small>ویژه پروژه‌های بزرگ و طبق هماهنگی</small></span></label>
        </section>

        <section class="order-card buyer-card">
          <h3>♙ اطلاعات خریدار سازمانی</h3>
          <div class="form-grid">
            <label>نام شرکت / خریدار *<input name="name" required value="{{ old('name') }}" placeholder="مثال: شرکت عمران سازه نوین"></label>
            <label>شماره تماس *<input name="mobile" required value="{{ old('mobile') }}" placeholder="مثال: 0912..."></label>
            <label>ایمیل<input name="email" value="{{ old('email') }}" placeholder="info@company.ir"></label>
            <label>شهر مقصد *<input name="city" value="{{ old('city') }}" placeholder="تهران"></label>
            <label class="full">آدرس مقصد جهت تحویل<textarea name="address" rows="2" placeholder="استان، شهر، آدرس دقیق پروژه یا انبار">{{ old('address') }}</textarea></label>
          </div>
          <div class="order-actions">
            <button class="btn primary big">🛒 ثبت نهایی سفارش</button>
            <button class="btn outline big" formaction="{{ route('quote.store') }}">▤ دریافت پیش‌فاکتور</button>
          </div>
        </section>

        <section class="order-card payment-card">
          <h3>▣ روش پرداخت</h3>
          <label class="radio-row selected"><input type="radio" checked><span><b>پرداخت آنلاین (درگاه امن بانکی)</b><small>پرداخت از طریق درگاه معتبر</small></span></label>
          <label class="radio-row"><input type="radio" disabled><span><b>واریز به حساب و ارسال فیش</b><small>دریافت پیش‌فاکتور و واریز وجه</small></span></label>
          <label class="radio-row"><input type="radio" disabled><span><b>اعتبار سازمانی</b><small>ویژه مشتریان حقوقی دارای قرارداد</small></span></label>
          <div class="safe-pay"><span>✓</span><div><b>پرداخت امن و مطمئن</b><small>اطلاعات پرداخت با استانداردهای بانکی محافظت می‌شود.</small></div></div>
        </section>
      </div>
    </form>
  </div>
</section>
</main>
@endsection
