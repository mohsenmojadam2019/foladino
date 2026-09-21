<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','فولادینو') | فروش عمده محصولات فولادی</title>
    <meta name="description" content="@yield('description','فروش مستقیم و عمده محصولات فولادی فولادینو با قیمت روز، سفارش آنلاین و ارسال سراسر کشور')">
    <link rel="icon" href="{{ $siteSettings['logo_image'] ?? '/images/logo-mark.svg' }}">
    <link rel="stylesheet" href="/css/site.css">
    @stack('styles')
</head>
<body class="@yield('body_class')">
<header class="site-header">
    <div class="shell header-row">
        <a class="brand" href="{{ route('home') }}">
            <span class="brand-mark"><img src="{{ $siteSettings['logo_image'] ?? '/images/logo-mark.svg' }}" alt=""></span>
            <span><strong>فولادینو</strong><small>قدرت در اعتماد</small></span>
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
            <a class="outline-link" href="tel:02191003333">۰۲۱-۹۱۰۰۳۳۳۳</a>
            <a class="orange-link" href="/admin">ورود / ثبت‌نام سازمانی</a>
            <button id="menuBtn" class="menu-btn" type="button">☰</button>
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
                <span class="brand-mark"><img src="{{ $siteSettings['logo_image'] ?? '/images/logo-mark.svg' }}" alt=""></span>
                <span><strong>فولادینو</strong><small>قدرت در اعتماد</small></span>
            </a>
            <p>تولید و عرضه مستقیم محصولات فولادی فولادینو برای پروژه‌های ساختمانی، صنعتی و سازمانی.</p>
            <div class="socials"><span>in</span><span>◎</span><span>✈</span></div>
        </div>
        <div><h4>دسترسی سریع</h4><a href="{{ route('home') }}">خانه</a><a href="{{ route('products') }}">محصولات</a><a href="{{ route('prices') }}">قیمت روز</a><a href="{{ route('bulk-order') }}">سفارش عمده</a></div>
        <div><h4>محصولات</h4>@foreach(($categories ?? collect())->take(6) as $c)<a href="{{ route('products',['category'=>$c->slug]) }}">{{ $c->name }}</a>@endforeach</div>
        <div><h4>خدمات مشتریان</h4><a href="{{ route('about') }}">درباره فولادینو</a><a href="{{ route('contact') }}">تماس با ما</a><a href="{{ route('bulk-order') }}">راهنمای خرید عمده</a><span>ارسال سراسر کشور</span></div>
        <div class="newsletter"><h4>عضویت در خبرنامه</h4><p>از آخرین قیمت‌ها و موجودی محصولات مطلع شوید.</p><div><input placeholder="ایمیل سازمانی شما"><button>اشتراک</button></div></div>
    </div>
    <div class="shell footer-bottom"><span>تمامی حقوق این وب‌سایت متعلق به شرکت فولادینو است. © {{ jdate_fa(now(),'Y') }}</span><span>باهم، سازنده فردا</span></div>
</footer>
<script src="/js/site.js"></script>
@stack('scripts')
</body>
</html>
