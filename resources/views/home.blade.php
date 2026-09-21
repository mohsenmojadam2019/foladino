@extends('layouts.app')
@section('body_class','home-reference-page')
@section('content')
<main id="top" class="home-reference">
    <section class="f-hero">
        <div class="f-shell f-hero-grid">
            <aside class="f-market-card" aria-label="نمای کلی بازار آهن آلات">
                <div class="f-panel-head">
                    <h3><span class="f-live-dot"></span> نمای کلی بازار آهن‌آلات</h3>
                    <a href="#prices">مشاهده همه</a>
                </div>

                <div class="f-market-list">
                    @foreach($products->take(5) as $p)
                        <div class="f-market-row">
                            <b>{{ $p->category?->name ?? $p->name }}</b>
                            <span class="f-price">{{ money_fa($p->price) }}</span>
                            <em class="{{ $p->price_change < 0 ? 'is-down' : 'is-up' }}">
                                {{ $p->price_change > 0 ? '+' : '' }}{{ fa_digits($p->price_change) }}٪
                            </em>
                            <svg class="f-spark {{ $p->price_change < 0 ? 'is-down' : 'is-up' }}" viewBox="0 0 74 28" aria-hidden="true">
                                <polyline points="2,18 10,14 18,17 27,8 35,12 43,9 51,15 60,7 72,11"/>
                            </svg>
                        </div>
                    @endforeach
                </div>

                <div class="f-market-foot">
                    <span class="f-chart-icon">▥</span>
                    آخرین بروزرسانی: امروز {{ jdate_fa(now(),'H:i') }}
                </div>
            </aside>

            <div class="f-hero-stage">
                <div class="f-hero-copy">
                    <div class="f-eyebrow">قیمت شفاف <span>•</span> تأمین مطمئن <span>•</span> تحویل سراسر کشور</div>
                    @php($heroParts = explode('|', $siteSettings['hero_title'] ?? 'بازار هوشمند|خرید آهن‌آلات'))
                    <h1>{{ $heroParts[0] ?? 'بازار هوشمند' }}<br><span>{{ $heroParts[1] ?? 'خرید آهن‌آلات' }}</span></h1>
                    <p>{{ $siteSettings['hero_subtitle'] ?? 'فولادینو؛ پلی میان پروژه‌های بزرگ امروز و آینده‌ای محکم‌تر' }}</p>
                    <div class="f-hero-actions">
                        <a class="f-btn f-btn-outline" href="#prices">مشاهده قیمت‌ها</a>
                        <a class="f-btn f-btn-primary" href="#quote">دریافت استعلام سریع <span>←</span></a>
                    </div>
                    <div class="f-hero-stats">
                        <div><span class="f-stat-icon">⌂</span><b>{{ $siteSettings['factories_count'] ?? '۵۰۰+' }}</b><small>کارخانه معتبر</small></div>
                        <div><span class="f-stat-icon">♙</span><b>{{ $siteSettings['active_customers'] ?? '۱۰,۰۰۰+' }}</b><small>مشتری فعال</small></div>
                        <div><span class="f-stat-icon">▥</span><b>{{ $siteSettings['annual_tons'] ?? '۱۰۰,۰۰۰+' }}</b><small>تن تأمین سالانه</small></div>
                    </div>
                </div>

                <div class="f-hero-badge">مطمئن‌تر<br>سریع‌تر<br><strong>هوشمندتر</strong></div>
            </div>
        </div>
    </section>

    <section id="products" class="f-shell f-categories">
        @foreach($categories as $cat)
            <a class="f-category" href="#prices">
                <div class="f-category-copy">
                    <h3>{{ $cat->name }}</h3>
                    <p>{{ match($cat->slug){
                        'rebar'=>'میلگرد آجدار و ساده در سایزهای مختلف',
                        'beam'=>'انواع تیرآهن IPE، IPN و هاش',
                        'sheet'=>'ورق گرم، سرد و گالوانیزه',
                        'pipe'=>'لوله‌های صنعتی و ساختمانی و گالوانیزه',
                        'profile'=>'پروفیل ساختمانی و صنعتی',
                        default=>'مقاطع فولادی متنوع'
                    } }}</p>
                </div>
                <img src="{{ $cat->icon }}" alt="{{ $cat->name }}">
                <span class="f-round-arrow">←</span>
            </a>
        @endforeach
    </section>

    <section class="f-shell f-feature-row" id="services">
        <div class="f-card f-quote-card" id="quote">
            <div class="f-quote-top">
                <div>
                    <h2>استعلام هوشمند قیمت</h2>
                    <p>در چند ثانیه، قیمت روز را از معتبرترین کارخانه‌ها دریافت کنید.</p>
                </div>
                <div class="f-ai-bot" aria-hidden="true">
                    <span>AI</span>
                    <i></i>
                </div>
            </div>

            <form id="quickQuoteForm" class="f-quick-form" onsubmit="return false;">
                <select id="quickProduct">
                    <option value="">نوع محصول</option>
                    @foreach($categories as $c)<option value="{{ $c->name }}">{{ $c->name }}</option>@endforeach
                </select>
                <select id="quickSpec">
                    <option value="">سایز / مشخصات</option>
                    <option>استاندارد متداول</option>
                    <option>سایز سفارشی</option>
                </select>
                <input id="quickAmount" type="number" min="0" step="0.1" placeholder="مقدار (تن)">
                <button type="button" class="f-btn f-btn-primary" data-open-quote>دریافت استعلام <span>←</span></button>
            </form>
        </div>

        <div class="f-card f-project-card">
            <div class="f-project-visual" style="background-image:url('{{ $siteSettings['project_image'] ?? '/images/project.svg' }}')"></div>
            <div class="f-project-copy">
                <h2>تأمین برای پروژه‌های عمرانی</h2>
                <p>از ساختمان‌های مسکونی تا پروژه‌های ملی، فولادینو همراه مطمئن شماست.</p>
                <a href="#quote" class="f-link-btn">مشاهده راهکارهای سازمانی</a>
            </div>
        </div>

        <div class="f-card f-delivery-card">
            <div class="f-delivery-copy">
                <h2>پوشش ارسال به سراسر ایران</h2>
                <p>تحویل سریع و مطمئن در همه استان‌ها</p>
                <ul>
                    <li>ناوگان معتبر</li>
                    <li>تحویل در محل پروژه</li>
                    <li>پیگیری آنلاین سفارش</li>
                </ul>
                <a href="#quote">مشاهده جزئیات</a>
            </div>
            <div class="f-map-wrap">
                <img src="{{ $siteSettings['delivery_map_image'] ?? '/images/iran-map.svg' }}" alt="پوشش ارسال به سراسر ایران">
                <span class="f-map-badge">🚚 ارسال<br>تا سراسر ایران</span>
            </div>
        </div>
    </section>

    <section id="prices" class="f-shell f-data-row">
        <div class="f-card f-latest-prices">
            <div class="f-panel-head">
                <h2>آخرین بروزرسانی قیمت‌ها</h2>
                <a href="#quote">مشاهده همه</a>
            </div>
            <div class="f-price-list">
                @foreach($products->take(5) as $p)
                    <div class="f-price-line">
                        <span class="f-time">{{ jdate_fa(now()->subMinutes($loop->index * 3),'H:i') }}</span>
                        <em class="{{ $p->price_change < 0 ? 'is-down' : 'is-up' }}">{{ $p->price_change > 0 ? '+' : '' }}{{ fa_digits($p->price_change) }}٪</em>
                        <b>{{ money_fa($p->price) }}</b>
                        <span class="f-product-name">{{ $p->name }} <small>{{ $p->factory?->name }}</small></span>
                        <img src="{{ $p->image }}" alt="">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="f-card f-smart-panel">
            <div class="f-panel-head f-smart-head">
                <div>
                    <h2>پیشنهاد هوشمند فولادینو</h2>
                    <p>با تحلیل قیمت، موجودی و اعتبار کارخانه، بهترین گزینه برای شما پیشنهاد می‌شود.</p>
                </div>
                <span class="f-ai-pill">AI</span>
            </div>

            <div class="f-supplier-grid">
                @foreach($products->take(3) as $p)
                    <article class="f-supplier-card {{ $loop->first ? 'is-featured' : '' }}">
                        <span class="f-supplier-name">{{ $p->factory?->name ?? 'کارخانه منتخب' }}</span>
                        <span class="f-chip">{{ $loop->first ? 'بهترین قیمت' : ($loop->index===1 ? 'تعادل قیمت و کیفیت' : 'تحویل سریع') }}</span>
                        <div class="f-supplier-rating">★ {{ fa_digits(number_format(4.9 - ($loop->index * .2),1)) }}</div>
                        <b>{{ money_fa($p->price) }}</b>
                        <small>تومان/کیلو</small>
                        <a href="#quote">انتخاب</a>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="f-card f-testimonials">
            <div class="f-panel-head">
                <h2>تجربه مشتریان ما</h2>
                <a href="#">مشاهده همه</a>
            </div>
            <div class="f-testimonial-grid">
                @foreach($testimonials as $t)
                    <blockquote>
                        <p>«{{ $t->quote }}»</p>
                        <footer>
                            <img src="{{ $t->avatar }}" alt="{{ $t->name }}">
                            <span><b>{{ $t->name }}</b><small>{{ $t->role }}</small></span>
                        </footer>
                    </blockquote>
                @endforeach
            </div>
            <div class="f-mini-stats">
                <div><b>۹۵٪+</b><span>رضایت مشتریان</span></div>
                <div><b>۳,۰۰۰+</b><span>پروژه موفق</span></div>
                <div><b>۵+ سال</b><span>همراهی مطمئن</span></div>
            </div>
        </div>
    </section>

    <section id="factories" class="f-shell f-factory-strip">
        <div class="f-factory-title">
            <h2>برخی از کارخانه‌های همکار ما</h2>
            <p>از معتبرترین تولیدکنندگان کشور</p>
        </div>
        <div class="f-factory-logos">
            @foreach($factories as $f)
                <div><img src="{{ $f->logo }}" alt="{{ $f->name }}"><span>{{ $f->name }}</span></div>
            @endforeach
        </div>
    </section>

    <section class="f-final-cta">
        <div class="f-shell f-cta-inner">
            <img src="{{ $siteSettings['cta_image'] ?? '/images/coil.svg' }}" alt="کلاف فولادی" class="f-cta-steel">
            <a href="#quote" class="f-btn f-btn-primary f-cta-button">همین حالا استعلام بگیرید <span>←</span></a>
            <div class="f-cta-copy">
                <h2>برای پروژه بعدی خود، <span>هوشمندتر</span> تأمین کنید</h2>
                <p>با فولادینو خرید آهن‌آلات ساده‌تر، سریع‌تر و مطمئن‌تر است.</p>
            </div>
            <div class="f-cta-features">
                <span>◉ قیمت شفاف</span>
                <span>◇ تحویل مطمئن</span>
                <span>◎ پشتیبانی تخصصی</span>
            </div>
        </div>
    </section>

    <div class="f-quote-modal" id="quoteModal" aria-hidden="true">
        <div class="f-quote-modal-card" role="dialog" aria-modal="true" aria-labelledby="quoteModalTitle">
            <button type="button" class="f-modal-close" data-close-quote aria-label="بستن">×</button>
            <h2 id="quoteModalTitle">تکمیل درخواست استعلام</h2>
            <p>اطلاعات تماس را وارد کنید تا کارشناسان فولادینو با شما تماس بگیرند.</p>
            <form method="post" action="{{ route('quote.store') }}" class="f-modal-form">
                @csrf
                <input type="hidden" name="product_name" id="modalProduct">
                <input type="hidden" name="amount" id="modalAmount">
                <label>نام و نام خانوادگی<input name="name" required maxlength="120" placeholder="نام شما"></label>
                <label>شماره تماس<input name="mobile" required maxlength="20" inputmode="tel" placeholder="۰۹۱۲..."></label>
                <label>شهر مقصد<input name="city" maxlength="100" placeholder="مثلاً تهران"></label>
                <button class="f-btn f-btn-primary" type="submit">ثبت درخواست استعلام</button>
            </form>
        </div>
    </div>
</main>
@endsection
