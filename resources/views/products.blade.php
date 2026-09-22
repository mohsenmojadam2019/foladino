@extends('layouts.app')
@section('title','محصولات')
@section('content')
<main>
<section class="page-hero">
  <div class="shell"><div>
    <div class="crumb">خانه ‹ محصولات</div>
    <h1>محصولات فولادینو</h1>
    <p>کیفیت مطمئن، تأمین پایدار و قیمت روز برای پروژه‌های بزرگ شما</p>
  </div></div>
</section>

<section class="catalog-section">
  <div class="shell catalog-layout">
    <aside class="filters" id="catalogFilters">
      <button class="filter-title" type="button" data-filter-toggle>
        <h3>فیلتر محصولات</h3><span>⌁</span>
      </button>
      <form method="get" action="{{ route('products') }}">
        <div class="filter-block">
          <h4>دسته‌بندی محصولات <span>⌃</span></h4>
          <label class="filter-check"><input type="radio" name="category" value="" @checked(!request('category'))> همه محصولات</label>
          @foreach($categories as $c)
            <label class="filter-check"><input type="radio" name="category" value="{{ $c->slug }}" @checked(request('category')===$c->slug)> {{ $c->name }}</label>
          @endforeach
        </div>
        <div class="filter-block">
          <h4>کارخانه تولیدکننده <span>⌃</span></h4>
          <select name="factory">
            <option value="">همه کارخانه‌ها</option>
            @foreach(($factories ?? collect()) as $f)<option value="{{ $f->slug }}" @selected(request('factory')===$f->slug)>{{ $f->name }}</option>@endforeach
          </select>
        </div>
        <div class="filter-block">
          <h4>وضعیت موجودی <span>⌃</span></h4>
          <label class="filter-check"><input type="radio" name="stock" value="" @checked(!request('stock'))> همه</label>
          <label class="filter-check"><input type="radio" name="stock" value="available" @checked(request('stock')==='available')> موجود در انبار</label>
          <label class="filter-check"><input type="radio" name="stock" value="call" @checked(request('stock')==='call')> موجودی محدود / استعلام</label>
          <label class="filter-check"><input type="radio" name="stock" value="unavailable" @checked(request('stock')==='unavailable')> ناموجود</label>
        </div>
        <div class="filter-actions">
          <button class="btn primary block">⌁ اعمال فیلترها</button>
          <a class="clear-filter" href="{{ route('products') }}">↻ پاک کردن فیلترها</a>
        </div>
      </form>
    </aside>

    <div class="catalog-main">
      <form class="catalog-topbar" method="get" action="{{ route('products') }}">
        @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
        @if(request('stock'))<input type="hidden" name="stock" value="{{ request('stock') }}">@endif
        @if(request('factory'))<input type="hidden" name="factory" value="{{ request('factory') }}">@endif
        <div class="catalog-search"><input name="q" value="{{ request('q') }}" placeholder="جستجوی محصول، نام، کد کالا یا مشخصات..."><button class="btn primary">جستجو</button></div>
        <div class="catalog-sort"><span>{{ fa_digits($products->total()) }} محصول</span><select name="sort" onchange="this.form.submit()"><option value="">پربازدیدترین</option><option value="price_asc" @selected(request('sort')==='price_asc')>کمترین قیمت</option><option value="price_desc" @selected(request('sort')==='price_desc')>بیشترین قیمت</option></select></div>
      </form>

      <div class="product-list">
        @forelse($products as $p)
        <article class="product-row">
          <div class="row-product">
            <img src="{{ $p->image }}" alt="{{ $p->name }}" loading="lazy">
            <div><h3>{{ $p->name }}</h3><small>{{ $p->category?->name }} · {{ $p->standard }}</small></div>
          </div>

          <div class="row-specs">
            <span><small>سایز</small><b>{{ $p->size ?: 'استاندارد' }}</b></span>
            <span><small>استاندارد</small><b>{{ $p->standard ?: 'ملی' }}</b></span>
            <span><small>کارخانه</small><b>{{ $p->factory?->name ?? 'فولادینو' }}</b></span>
            <span><small>واحد</small><b>{{ $p->unit }}</b></span>
          </div>

          <div class="availability {{ $p->stock_status }}">
            {{ $p->stock_status==='available' ? 'موجود در انبار' : ($p->stock_status==='call' ? 'موجودی محدود' : 'ناموجود') }}
            <small>{{ $p->stock_status==='available' ? 'تحویل ۲ تا ۳ روز کاری' : 'زمان تحویل با واحد فروش' }}</small>
          </div>

          <div class="row-price">
            <strong>{{ money_fa($p->price) }}</strong><small>تومان / {{ $p->unit }}</small>
            <a class="btn primary" href="{{ route('bulk-order',['product'=>$p->slug]) }}">🛒 ثبت سفارش عمده</a>
            <a class="btn outline" href="{{ route('bulk-order',['product'=>$p->slug]) }}">مشاهده جزئیات</a>
          </div>
        </article>
        @empty
          <div class="card" style="padding:45px;text-align:center"><h3>محصولی پیدا نشد</h3><p class="muted">فیلترها را تغییر دهید یا با واحد فروش تماس بگیرید.</p></div>
        @endforelse
      </div>

      @if($products->hasPages())
      <div class="pagination-simple">
        @if(!$products->onFirstPage())<a href="{{ $products->previousPageUrl() }}">‹</a>@endif
        @for($i=max(1,$products->currentPage()-2);$i<=min($products->lastPage(),$products->currentPage()+2);$i++)
          @if($i===$products->currentPage())<b>{{ fa_digits($i) }}</b>@else<a href="{{ $products->url($i) }}">{{ fa_digits($i) }}</a>@endif
        @endfor
        @if($products->hasMorePages())<a href="{{ $products->nextPageUrl() }}">›</a>@endif
      </div>
      @endif
    </div>
  </div>
</section>
</main>
@endsection
