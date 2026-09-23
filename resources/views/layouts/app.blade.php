<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','فولادینو') | فروش عمده محصولات فولادی</title>
    <meta name="description" content="@yield('description','فروش مستقیم و عمده محصولات فولادی فولادینو با قیمت روز، سفارش آنلاین و ارسال سراسر کشور')">
    <link rel="icon" href="{{ site_asset($siteSettings['logo_image'] ?? '/images/logo-mark.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/site.css?v=14050701') }}">
    @stack('styles')
</head>
<body class="@yield('body_class')">
<header class="site-header">
    <div class="shell header-row">
        <a class="brand" href="{{ route('home') }}" aria-label="فولادینو">
            <span class="brand-mark"><img src="{{ site_asset($siteSettings['logo_image'] ?? '/images/logo-mark.svg') }}" alt=""></span>
            <span class="brand-copy"><strong>فولادینو</strong><small>قدرت در اعتماد</small></span>
        </a>

        <nav class="nav" id="mainNav">
            <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">خانه</a>
            <a class="{{ request()->routeIs('products') ? 'active' : '' }}" href="{{ route('products') }}">محصولات</a>
            <a class="{{ request()->routeIs('prices') ? 'active' : '' }}" href="{{ route('prices') }}">قیمت روز</a>
            <a class="{{ request()->routeIs('bulk-order') ? 'active' : '' }}" href="{{ route('bulk-order') }}">سفارش عمده</a>
            <a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">درباره ما</a>
            <a class="{{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">تماس با ما</a>
        </nav>

        <div class="header-actions">
            <a class="header-phone" href="tel:02191003333">
                <span>☎</span><b>۰۲۱-۹۱۰۰۳۳۳۳</b>
            </a>
            <a class="orange-link" href="/admin"><span>👤</span> ورود / ثبت نام سازمانی</a>
            <button id="menuBtn" class="menu-btn" type="button" aria-label="منو">☰</button>
        </div>
    </div>
</header>

@if(session('success'))<div class="flash success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="flash error">{{ session('error') }}</div>@endif
@if(isset($errors) && $errors->any())<div class="flash error">{{ $errors->first() }}</div>@endif

@yield('content')

<footer class="site-footer">
    <div class="shell footer-grid">
        <div class="footer-brand">
            <a class="brand" href="{{ route('home') }}">
                <span class="brand-mark"><img src="{{ site_asset($siteSettings['logo_image'] ?? '/images/logo-mark.svg') }}" alt=""></span>
                <span class="brand-copy"><strong>فولادینو</strong><small>قدرت در اعتماد</small></span>
            </a>
            <p>تولیدکننده و تأمین‌کننده مطمئن انواع مقاطع فولادی برای پروژه‌های بزرگ در سراسر ایران.</p>
            <div class="socials"><span>in</span><span>◎</span><span>➤</span><span>◉</span></div>
        </div>

        <div class="footer-links">
            <h4>دسترسی سریع</h4>
            <a href="{{ route('home') }}">خانه</a><a href="{{ route('products') }}">محصولات</a>
            <a href="{{ route('prices') }}">قیمت روز</a><a href="{{ route('bulk-order') }}">سفارش عمده</a>
            <a href="{{ route('about') }}">درباره ما</a><a href="{{ route('contact') }}">تماس با ما</a>
        </div>

        <div class="footer-links">
            <h4>محصولات</h4>
            @foreach(($categories ?? collect())->take(6) as $c)
                <a href="{{ route('products',['category'=>$c->slug]) }}">{{ $c->name }}</a>
            @endforeach
        </div>

        <div class="footer-links">
            <h4>خدمات مشتریان</h4>
            <a href="{{ route('contact') }}">سوالات متداول</a>
            <a href="{{ route('bulk-order') }}">راهنمای ثبت سفارش</a>
            <span>شرایط ارسال</span><span>شرایط بازگشت</span><span>حریم خصوصی</span><span>قوانین و مقررات</span>
        </div>

        <div class="newsletter">
            <h4>عضویت در خبرنامه</h4>
            <p>از آخرین قیمت‌ها و اخبار فولادینو مطلع شوید.</p>
            <div><input type="email" placeholder="ایمیل سازمانی شما"><button type="button">اشتراک</button></div>
        </div>
    </div>
    <div class="shell footer-bottom">
        <span>تمامی حقوق این وب‌سایت متعلق به شرکت فولادینو است. © {{ jdate_fa(now(),'Y') }}</span>
        <strong>باهم، سازنده فردا</strong>
    </div>
</footer>

<script src="{{ asset('js/site.js?v=14050701') }}"></script>
@stack('scripts')
</body>
</html>
