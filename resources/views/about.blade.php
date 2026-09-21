@extends('layouts.app')
@section('title','درباره ما')
@section('content')
<main>
<section class="page-hero" style="--hero:url('{{ $siteSettings['hero_image'] ?? '/images/hero-steel.svg' }}')"><div class="shell"><div><span>خانه / درباره ما</span><h1>درباره فولادینو</h1><p>یک شرکت خصوصی برای تولید، عرضه مستقیم و فروش عمده محصولات فولادی</p></div></div></section>
<section class="section shell about-grid">
  <div class="about-copy"><span class="kicker">باهم، سازنده فردا</span><h2>ما بازار واسطه‌ها نیستیم؛ فروش مستقیم محصولات خودمان هستیم.</h2><p>فولادینو با هدف ساده‌کردن خرید عمده فولاد برای شرکت‌ها و پروژه‌ها شکل گرفته است. محصول، قیمت و فرآیند فروش همگی در یک مسیر شفاف ارائه می‌شوند تا مشتری سازمانی بدون سردرگمی، کالای موردنیاز را انتخاب و سفارش خود را ثبت کند.</p><p>تمرکز ما روی کیفیت پایدار، اعلام قیمت روز، پاسخ‌گویی سریع واحد فروش و تحویل برنامه‌ریزی‌شده است.</p><div class="about-stats"><div><b>۱۰۰٪</b><span>فروش مستقیم</span></div><div><b>روزانه</b><span>به‌روزرسانی قیمت</span></div><div><b>سراسری</b><span>پوشش ارسال</span></div></div></div>
  <div class="about-visual"><img src="/images/project.svg" alt="فولادینو"><div><b>فولادینو</b><span>قدرت در اعتماد</span></div></div>
</section>
<section class="section muted-section"><div class="shell"><div class="section-head centered"><div><span class="kicker">اصول همکاری</span><h2>آنچه مشتری سازمانی از ما دریافت می‌کند</h2></div></div><div class="values-grid"><article><span>01</span><h3>شفافیت قیمت</h3><p>قیمت روز محصول قبل از ثبت سفارش در دسترس مشتری است.</p></article><article><span>02</span><h3>تضمین مشخصات</h3><p>کالا بر اساس مشخصات فنی ثبت‌شده در سفارش تأمین می‌شود.</p></article><article><span>03</span><h3>پاسخ‌گویی واقعی</h3><p>پیگیری سفارش از طریق واحد فروش و پشتیبانی شرکت انجام می‌شود.</p></article><article><span>04</span><h3>همکاری بلندمدت</h3><p>برای پروژه‌های تکرارشونده شرایط همکاری سازمانی تعریف می‌کنیم.</p></article></div></div></section>
</main>
@endsection
