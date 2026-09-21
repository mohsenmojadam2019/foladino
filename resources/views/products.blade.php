@extends('layouts.app')
@section('title','محصولات')
@section('content')
<main>
<section class="page-hero" style="--hero:url('{{ $siteSettings['hero_image'] ?? '/images/hero-steel.svg' }}')">
  <div class="shell"><div><span>خانه / محصولات</span><h1>محصولات فولادینو</h1><p>کیفیت مطمئن، موجودی شفاف و قیمت روز برای سفارش‌های عمده</p></div></div>
</section>

<section class="section shell catalog-layout">
  <aside class="filters">
    <div class="filter-title"><h3>فیلتر محصولات</h3><span>⌁</span></div>
    <form method="get" action="{{ route('products') }}">
      <label>جستجو<input name="q" value="{{ request('q') }}" placeholder="نام، کد یا مشخصات..."></label>
      <label>دسته‌بندی<select name="category"><option value="">همه محصولات</option>@foreach($categories as $c)<option value="{{ $c->slug }}" @selected(request('category')===$c->slug)>{{ $c->name }}</option>@endforeach</select></label>
      <label>وضعیت موجودی<select name="stock"><option value="">همه</option><option value="available" @selected(request('stock')==='available')>موجود در انبار</option><option value="call" @selected(request('stock')==='call')>استعلام موجودی</option><option value="unavailable" @selected(request('stock')==='unavailable')>ناموجود</option></select></label>
      <button class="btn primary block">اعمال فیلترها</button>
      <a class="clear-filter" href="{{ route('products') }}">پاک کردن فیلترها</a>
    </form>
  </aside>

  <div class="catalog-main">
    <div class="catalog-toolbar"><div><h2>فهرست محصولات</h2><span>{{ fa_digits($products->total()) }} محصول</span></div><a href="{{ route('prices') }}">مشاهده قیمت روز ←</a></div>
    <div class="product-list">
      @forelse($products as $p)
      <article class="product-row">
        <div class="row-product"><img src="{{ $p->image }}" alt="{{ $p->name }}"><div><small>{{ $p->category?->name }}</small><h3>{{ $p->name }}</h3><p>{{ $p->description }}</p></div></div>
        <div class="row-specs"><span><small>سایز</small><b>{{ $p->size ?: 'استاندارد' }}</b></span><span><small>استاندارد</small><b>{{ $p->standard ?: 'ملی' }}</b></span><span><small>تولید</small><b>فولادینو</b></span></div>
        <div class="availability {{ $p->stock_status }}"><i></i>{{ $p->stock_status==='available' ? 'موجود در انبار' : ($p->stock_status==='call' ? 'نیازمند استعلام' : 'ناموجود') }}<small>{{ $p->stock_status==='available' ? 'تحویل طبق برنامه فروش' : 'برای زمان تحویل تماس بگیرید' }}</small></div>
        <div class="row-price"><strong>{{ money_fa($p->price) }}</strong><small>تومان / {{ $p->unit }}</small><a class="btn primary" href="{{ route('bulk-order',['product'=>$p->slug]) }}">ثبت سفارش عمده</a></div>
      </article>
      @empty
      <div class="empty-state"><h3>محصولی پیدا نشد</h3><p>فیلترها را تغییر دهید یا با واحد فروش تماس بگیرید.</p></div>
      @endforelse
    </div>
    @if($products->hasPages())
    <div class="pagination-simple">
      @if($products->onFirstPage())<span>قبلی</span>@else<a href="{{ $products->previousPageUrl() }}">قبلی</a>@endif
      <b>صفحه {{ fa_digits($products->currentPage()) }} از {{ fa_digits($products->lastPage()) }}</b>
      @if($products->hasMorePages())<a href="{{ $products->nextPageUrl() }}">بعدی</a>@else<span>بعدی</span>@endif
    </div>
    @endif
  </div>
</section>
</main>
@endsection
