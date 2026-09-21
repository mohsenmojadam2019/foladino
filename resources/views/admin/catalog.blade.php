@extends('admin.layout')
@section('title','مدیریت محصولات')
@section('heading','مدیریت محصولات')
@section('subheading','کنترل کاتالوگ، دسته‌بندی‌ها، کارخانه‌ها و موجودی')
@section('actions')
<button class="btn btn-primary" data-modal="productModal">+ افزودن محصول</button>
@endsection

@section('content')
@php
  $available=$products->where('stock_status','available')->count();
  $limited=$products->where('stock_status','call')->count();
  $inactive=$products->where('is_active',false)->count();
@endphp

<div class="admin-page-kpis">
  <article><span>▦</span><div><small>کل محصولات</small><b>{{ fa_digits($products->count()) }}</b></div></article>
  <article><span>✓</span><div><small>موجود در انبار</small><b>{{ fa_digits($available) }}</b></div></article>
  <article><span>!</span><div><small>نیازمند استعلام</small><b>{{ fa_digits($limited) }}</b></div></article>
  <article><span>×</span><div><small>غیرفعال</small><b>{{ fa_digits($inactive) }}</b></div></article>
</div>

<div class="admin-toolbar admin-toolbar-v2">
  <div class="toolbar-tabs">
    <button class="tab-btn active" data-tab="products">محصولات</button>
    <button class="tab-btn" data-tab="categories">دسته‌بندی‌ها</button>
    <button class="tab-btn" data-tab="factories">کارخانه‌ها</button>
  </div>
  <div class="admin-table-search"><span>⌕</span><input data-admin-table-search="#productsTable" placeholder="جستجو در محصولات..."></div>
</div>

<section class="admin-card tab-pane active" id="products">
  <div class="admin-card-head">
    <div><h3>فهرست محصولات</h3><p>{{ fa_digits($products->count()) }} محصول ثبت‌شده در سیستم</p></div>
    <span class="live-pill"><i></i> اطلاعات فعال</span>
  </div>

  <div class="admin-table-wrap">
    <table class="admin-table admin-products-table" id="productsTable">
      <thead>
        <tr><th>محصول</th><th>SKU</th><th>دسته‌بندی</th><th>کارخانه</th><th>قیمت</th><th>موجودی</th><th>وضعیت</th><th>آخرین تغییر</th><th>عملیات</th></tr>
      </thead>
      <tbody>
      @foreach($products as $p)
      <tr>
        <td><div class="table-product"><img src="{{ $p->image }}" alt=""><span><b>{{ $p->name }}</b><small>{{ $p->size }} · {{ $p->standard }}</small></span></div></td>
        <td><code>{{ $p->sku }}</code></td>
        <td>{{ $p->category?->name ?? '—' }}</td>
        <td>{{ $p->factory?->name ?? 'فولادینو' }}</td>
        <td><strong>{{ money_fa($p->price) }}</strong><small class="{{ $p->price_change<0?'neg':'pos' }}">{{ fa_digits($p->price_change) }}٪</small></td>
        <td><span class="status-badge {{ $p->stock_status==='available'?'won':($p->stock_status==='call'?'contacted':'lost') }}">{{ $p->stock_status==='available'?'موجود':($p->stock_status==='call'?'استعلام':'ناموجود') }}</span></td>
        <td><span class="status-badge {{ $p->is_active?'won':'lost' }}">{{ $p->is_active?'فعال':'غیرفعال' }}</span></td>
        <td>{{ jdate_fa($p->updated_at,'Y/m/d H:i') }}</td>
        <td>
          <div class="admin-row-actions">
            <button class="icon-btn admin-edit-product"
              data-modal="editProductModal"
              data-id="{{ $p->id }}"
              data-name="{{ $p->name }}"
              data-category="{{ $p->category_id }}"
              data-factory="{{ $p->factory_id }}"
              data-size="{{ $p->size }}"
              data-standard="{{ $p->standard }}"
              data-price="{{ $p->price }}"
              data-change="{{ $p->price_change }}"
              data-stock="{{ $p->stock_status }}"
              data-featured="{{ $p->is_featured?1:0 }}"
              data-active="{{ $p->is_active?1:0 }}">ویرایش</button>
            <form method="post" action="{{ route('admin.products.destroy',$p) }}" onsubmit="return confirm('این محصول حذف شود؟')">@csrf @method('DELETE')<button class="icon-btn danger">حذف</button></form>
          </div>
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</section>

<section class="admin-card tab-pane" id="categories">
  <div class="split-form">
    <form method="post" action="{{ route('admin.categories.store') }}">@csrf
      <div><h3>دسته‌بندی جدید</h3><p class="admin-form-help">گروه جدید برای سازمان‌دهی محصولات ایجاد کنید.</p></div>
      <input name="name" placeholder="نام دسته‌بندی" required>
      <input name="slug" placeholder="slug لاتین" required>
      <input name="sort_order" type="number" placeholder="ترتیب نمایش">
      <button class="btn btn-primary">ثبت دسته‌بندی</button>
    </form>
    <div>
      <div class="admin-card-head"><div><h3>دسته‌های فعلی</h3><p>{{ fa_digits($categories->count()) }} دسته</p></div></div>
      <div class="category-admin-grid">
        @foreach($categories as $c)
        <article><img src="{{ $c->icon }}" alt=""><div><b>{{ $c->name }}</b><small>{{ $c->slug }}</small></div><span>#{{ fa_digits($c->sort_order) }}</span></article>
        @endforeach
      </div>
    </div>
  </div>
</section>

<section class="admin-card tab-pane" id="factories">
  <div class="split-form">
    <form method="post" action="{{ route('admin.factories.store') }}">@csrf
      <div><h3>کارخانه جدید</h3><p class="admin-form-help">یک تولیدکننده یا مرکز تأمین جدید اضافه کنید.</p></div>
      <input name="name" placeholder="نام کارخانه" required>
      <input name="slug" placeholder="slug لاتین" required>
      <input name="province" placeholder="استان">
      <input name="city" placeholder="شهر">
      <button class="btn btn-primary">ثبت کارخانه</button>
    </form>
    <div>
      <div class="admin-card-head"><div><h3>شبکه کارخانه‌ها</h3><p>{{ fa_digits($factories->count()) }} مجموعه ثبت‌شده</p></div></div>
      <div class="factory-admin-grid">
        @foreach($factories as $f)
        <div><img src="{{ $f->logo }}" alt=""><b>{{ $f->name }}</b><small>{{ $f->province }} / {{ $f->city }}</small></div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<div class="modal" id="productModal">
  <div class="modal-box">
    <button class="modal-close">×</button><h3>افزودن محصول جدید</h3>
    <form class="form-grid" method="post" action="{{ route('admin.products.store') }}">@csrf
      <label>نام محصول<input name="name" required></label><label>SKU<input name="sku" required></label>
      <label>دسته‌بندی<select name="category_id" required><option value="">انتخاب کنید</option>@foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></label>
      <label>کارخانه<select name="factory_id"><option value="">فولادینو</option>@foreach($factories as $f)<option value="{{ $f->id }}">{{ $f->name }}</option>@endforeach</select></label>
      <label>سایز<input name="size"></label><label>استاندارد<input name="standard"></label>
      <label>قیمت<input name="price" type="number" required></label><label>درصد تغییر<input name="price_change" type="number" step="0.01"></label>
      <label>وضعیت موجودی<select name="stock_status"><option value="available">موجود</option><option value="call">استعلام</option><option value="unavailable">ناموجود</option></select></label>
      <label>تصویر<input name="image" value="/images/rebar.svg"></label>
      <label class="check-line"><input type="checkbox" name="is_featured" value="1"> محصول ویژه</label>
      <label class="check-line"><input type="checkbox" name="is_active" value="1" checked> فعال</label>
      <button class="btn btn-primary full">ذخیره محصول</button>
    </form>
  </div>
</div>

<div class="modal" id="editProductModal">
  <div class="modal-box">
    <button class="modal-close">×</button><h3>ویرایش محصول</h3>
    <form class="form-grid" method="post" id="editProductForm">@csrf @method('PUT')
      <label>نام محصول<input name="name" id="edit_name" required></label>
      <label>دسته‌بندی<select name="category_id" id="edit_category" required>@foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></label>
      <label>کارخانه<select name="factory_id" id="edit_factory"><option value="">فولادینو</option>@foreach($factories as $f)<option value="{{ $f->id }}">{{ $f->name }}</option>@endforeach</select></label>
      <label>سایز<input name="size" id="edit_size"></label>
      <label>استاندارد<input name="standard" id="edit_standard"></label>
      <label>قیمت<input name="price" id="edit_price" type="number" required></label>
      <label>درصد تغییر<input name="price_change" id="edit_change" type="number" step="0.01"></label>
      <label>موجودی<select name="stock_status" id="edit_stock"><option value="available">موجود</option><option value="call">استعلام</option><option value="unavailable">ناموجود</option></select></label>
      <label class="check-line"><input type="checkbox" name="is_featured" id="edit_featured" value="1"> محصول ویژه</label>
      <label class="check-line"><input type="checkbox" name="is_active" id="edit_active" value="1"> فعال</label>
      <button class="btn btn-primary full">ذخیره تغییرات</button>
    </form>
  </div>
</div>
@endsection