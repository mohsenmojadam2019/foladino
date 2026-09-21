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
    <link rel="stylesheet" href="/css/home-reference.css">
</head>
<body class="@yield('body_class')">
<header class="topbar f-topbar">
    <div class="f-shell f-header-inner">
        <a class="f-brand" href="{{ route('home') }}" aria-label="فولادینو">
            <img src="{{ $siteSettings['logo_image'] ?? '/images/logo-mark.svg' }}" alt="فولادینو">
            <span><strong>{{ $siteSettings['site_name'] ?? 'فولادینو' }}</strong><small>بازار هوشمند آهن‌آلات</small></span>
        </a>

        <nav class="f-main-nav" id="mainNav">
            <a class="active" href="#top">صفحه اصلی</a>
            <a href="#prices">قیمت‌ها</a>
            <a href="#products">خرید عمده</a>
            <a href="#factories">کارخانه‌ها</a>
            <a href="#services">خدمات</a>
            <a href="#footer">وبلاگ</a>
            <a href="#footer">درباره ما</a>
        </nav>

        <div class="f-header-search">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m21 21-4.6-4.6m2.6-5.1a7.7 7.7 0 1 1-15.4 0 7.7 7.7 0 0 1 15.4 0Z"/></svg>
            <input id="globalSearch" autocomplete="off" placeholder="جستجوی محصول، کارخانه یا استاندارد ...">
        </div>

        <div class="f-header-actions">
            <a class="f-support" href="tel:02191003333">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 13v-2a8 8 0 0 1 16 0v2M4 13h3v6H5a1 1 0 0 1-1-1v-5Zm16 0h-3v6h2a1 1 0 0 0 1-1v-5ZM17 19c0 1.1-1.3 2-3 2h-1"/></svg>
                <span><b>{{ $siteSettings['phone'] ?? '۰۲۱-۹۱۰۰۳۳۳۳' }}</b><small>مشاوره و پشتیبانی</small></span>
            </a>
            <a class="f-cart" href="#quote" aria-label="سبد استعلام">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2.2 10.2a2 2 0 0 0 2 1.6h7.5a2 2 0 0 0 1.9-1.4L21 7H7M10 20h.01M17 20h.01"/></svg>
                <i>۰</i>
            </a>
            <a class="f-login" href="/admin">ورود / ثبت‌نام</a>
            <button class="f-menu-btn" id="menuBtn" type="button" aria-label="نمایش منو">☰</button>
        </div>
    </div>
</header>

@if(session('success'))<div class="flash success">{{ session('success') }}</div>@endif
@if(isset($errors) && $errors->any())<div class="flash error">{{ $errors->first() }}</div>@endif

@yield('content')

<footer id="footer" class="footer">
  <div class="container footer-grid">
    <div><a class="brand footer-brand" href="/"><img src="{{ $siteSettings['logo_image'] ?? '/images/logo-mark.svg' }}"><span><strong>فولادینو</strong><small>بازار هوشمند آهن‌آلات</small></span></a><p>تأمین شفاف، سریع و قابل پیگیری برای پروژه‌های ساختمانی و صنعتی سراسر ایران.</p></div>
    <div><h4>دسترسی سریع</h4><a href="#products">محصولات</a><a href="#prices">قیمت‌ها</a><a href="#factories">کارخانه‌ها</a><a href="#footer">مجله فولادینو</a></div>
    <div><h4>خدمات</h4><a href="#quote">استعلام قیمت</a><a href="#services">خرید عمده</a><a href="#services">حمل و نقل</a><a href="#services">مشاوره پروژه</a></div>
    <div><h4>تماس</h4><span>{{ $siteSettings['support_phone'] ?? '۰۲۱-۹۱۰۰۷۰۰۰' }}</span><span>{{ $siteSettings['email'] ?? 'info@fooladino.ir' }}</span><span>{{ $siteSettings['address'] ?? 'تهران، دفتر مرکزی فولادینو' }}</span></div>
    <div class="newsletter"><h4>از آخرین تغییرات بازار مطلع شوید</h4><p>خبرنامه قیمت‌ها و تحلیل هفتگی فولاد</p><div><input placeholder="ایمیل خود را وارد کنید"><button class="btn btn-primary">عضویت</button></div></div>
  </div>
  <div class="container footer-bottom"><span>تمامی حقوق برای فولادینو محفوظ است. {{ jdate_fa(now(),'Y') }} ©</span><span>قیمت شفاف · تأمین مطمئن · تحویل سراسر کشور</span></div>
</footer>
<script src="/js/app.js"></script>
<script src="/js/home-reference.js"></script>
</body>
</html>
