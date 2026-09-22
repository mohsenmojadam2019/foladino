@extends('layouts.app')
@section('title','درباره ما')
@section('content')
<main>
<section class="page-hero"><div class="shell"><div><div class="crumb">خانه ‹ درباره ما</div><h1>درباره فولادینو</h1><p>تولید، عرضه مستقیم و همکاری مطمئن با پروژه‌های بزرگ</p></div></div></section>

<section class="about-wrap">
  <div class="shell about-grid">
    <div class="about-copy">
      <span class="eyebrow">باهم، سازنده فردا</span>
      <h2>تأمین مستقیم فولاد؛ با تمرکز بر کیفیت، شفافیت و تحویل قابل اتکا</h2>
      <p>فولادینو برای ساده‌کردن خرید عمده محصولات فولادی شکل گرفته است. مشتری سازمانی باید بتواند مشخصات کالا، قیمت روز، وضعیت موجودی و مسیر سفارش را بدون ابهام ببیند و یک ارتباط مستقیم با واحد فروش داشته باشد.</p>
      <p>تمرکز ما روی کیفیت پایدار، پاسخ‌گویی سریع، قیمت‌گذاری شفاف و هماهنگی دقیق حمل برای پروژه‌های ساختمانی و صنعتی است.</p>
      <div class="about-stats">
        <div><b>۱۰۰٪</b><span>فروش مستقیم</span></div>
        <div><b>روزانه</b><span>به‌روزرسانی قیمت</span></div>
        <div><b>سراسری</b><span>پوشش ارسال</span></div>
      </div>
    </div>
    <div class="about-visual"><img src="/images/hero/about-plant.jpg" alt="کارخانه و محصولات فولادینو"></div>
  </div>
</section>

<section class="section section-soft">
  <div class="shell">
    <div class="section-title"><div><span class="eyebrow">اصول همکاری</span><h2>آنچه مشتری سازمانی از فولادینو دریافت می‌کند</h2></div></div>
    <div class="values-grid">
      <article><span>01</span><h3>شفافیت قیمت</h3><p>قیمت روز و تغییرات بازار قبل از ثبت سفارش در دسترس مشتری است.</p></article>
      <article><span>02</span><h3>تضمین مشخصات</h3><p>کالا بر اساس مشخصات فنی ثبت‌شده و استانداردهای اعلامی تأمین می‌شود.</p></article>
      <article><span>03</span><h3>پاسخ‌گویی واقعی</h3><p>کارشناس فروش مسئول پیگیری سفارش از ثبت تا تحویل پروژه است.</p></article>
      <article><span>04</span><h3>همکاری بلندمدت</h3><p>برای خریدهای تکرارشونده و پروژه‌های بزرگ شرایط سازمانی تعریف می‌شود.</p></article>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell trust-strip">
    <div class="trust-dark"><span class="shield">✓</span><div><h3>اعتماد، بخشی از محصول ماست</h3><p>فرآیند شفاف فروش و پشتیبانی سازمانی</p><a class="btn ghost" href="{{ route('contact') }}">ارتباط با ما</a></div></div>
    <div class="trust-logos"><h3>زنجیره یکپارچه تأمین</h3><div><span><i>▥</i>قیمت روز</span><span><i>⚙</i>کنترل کیفیت</span><span><i>▤</i>لجستیک</span><span><i>☏</i>پشتیبانی</span></div></div>
    <div class="trust-support"><span>☏</span><div><h3>شروع همکاری سازمانی</h3><p>برای دریافت شرایط خرید عمده با واحد فروش صحبت کنید.</p><a class="btn outline" href="{{ route('bulk-order') }}">ثبت سفارش ←</a></div></div>
  </div>
</section>
</main>
@endsection
