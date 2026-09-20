<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $siteSettings['site_name'] ?? 'فولادینو' }} | بازار هوشمند آهن‌آلات</title>
    <meta name="description" content="قیمت لحظه‌ای و تأمین عمده میلگرد، تیرآهن، ورق، لوله و پروفیل از کارخانه‌های معتبر ایران">
    <link rel="icon" href="{{ $siteSettings['logo_image'] ?? '/images/logo-mark.svg' }}" type="image/svg+xml">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<header class="topbar">
    <div class="container nav-wrap">
        <a class="brand" href="{{ route('home') }}"><img src="{{ $siteSettings['logo_image'] ?? '/images/logo-mark.svg' }}" alt="فولادینو"><span><strong>فولادینو</strong><small>بازار هوشمند آهن‌آلات</small></span></a>
        <nav class="main-nav" id="mainNav">
            <a class="active" href="#top">صفحه اصلی</a><a href="#prices">قیمت‌ها</a><a href="#products">خرید عمده</a><a href="#factories">کارخانه‌ها</a><a href="#services">خدمات</a><a href="#articles">وبلاگ</a><a href="#footer">درباره ما</a>
        </nav>
        <div class="nav-actions">
            <div class="search-mini"><svg viewBox="0 0 24 24"><path d="m21 21-4.3-4.3m2.3-5.2A7.5 7.5 0 1 1 4 11.5a7.5 7.5 0 0 1 15 0Z"/></svg><input id="globalSearch" autocomplete="off" placeholder="جستجوی محصول، کارخانه یا استاندارد ..."></div>
            <a class="support" href="tel:02191003333"><b>{{ $siteSettings['phone'] ?? '۰۲۱-۹۱۰۰۳۳۳۳' }}</b><small>مشاوره و پشتیبانی</small></a>
            <a class="btn btn-primary btn-sm" href="/admin">ورود / ثبت‌نام</a>
            <button class="menu-btn" id="menuBtn" aria-label="منو">☰</button>
        </div>
    </div>
</header>
@if(session('success'))<div class="flash success">{{ session('success') }}</div>@endif
@if(isset($errors) && $errors->any())<div class="flash error">{{ $errors->first() }}</div>@endif
@yield('content')
<footer id="footer" class="footer">
  <div class="container footer-grid">
    <div><a class="brand footer-brand" href="/"><img src="{{ $siteSettings['logo_image'] ?? '/images/logo-mark.svg' }}"><span><strong>فولادینو</strong><small>بازار هوشمند آهن‌آلات</small></span></a><p>تأمین شفاف، سریع و قابل پیگیری برای پروژه‌های ساختمانی و صنعتی سراسر ایران.</p></div>
    <div><h4>دسترسی سریع</h4><a href="#products">محصولات</a><a href="#prices">قیمت‌ها</a><a href="#factories">کارخانه‌ها</a><a href="#articles">مجله فولادینو</a></div>
    <div><h4>خدمات</h4><a href="#quote">استعلام قیمت</a><a href="#services">خرید عمده</a><a href="#services">حمل و نقل</a><a href="#services">مشاوره پروژه</a></div>
    <div><h4>تماس</h4><span>{{ $siteSettings['support_phone'] ?? '۰۲۱-۹۱۰۰۷۰۰۰' }}</span><span>{{ $siteSettings['email'] ?? 'info@fooladino.ir' }}</span><span>{{ $siteSettings['address'] ?? 'تهران، دفتر مرکزی فولادینو' }}</span></div>
    <div class="newsletter"><h4>از آخرین تغییرات بازار مطلع شوید</h4><p>خبرنامه قیمت‌ها و تحلیل هفتگی فولاد</p><div><input placeholder="ایمیل خود را وارد کنید"><button class="btn btn-primary">عضویت</button></div></div>
  </div>
  <div class="container footer-bottom"><span>تمامی حقوق برای فولادینو محفوظ است. {{ jdate_fa(now(),'Y') }} ©</span><span>قیمت شفاف · تأمین مطمئن · تحویل سراسر کشور</span></div>
</footer>
<script src="/js/app.js"></script>
</body></html>
