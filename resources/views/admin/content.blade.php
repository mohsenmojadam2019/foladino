@extends('admin.layout')
@section('title','محتوا و مقالات')
@section('heading','محتوا و مقالات')
@section('subheading','مدیریت تحلیل بازار، آموزش و اخبار فولادینو')
@section('content')
<div class="admin-page-kpis">
  <article><span>✎</span><div><small>کل مقالات</small><b>{{ fa_digits($articles->count()) }}</b></div></article>
  <article><span>✓</span><div><small>منتشرشده</small><b>{{ fa_digits($articles->where('is_published',true)->count()) }}</b></div></article>
  <article><span>◷</span><div><small>پیش‌نویس</small><b>{{ fa_digits($articles->where('is_published',false)->count()) }}</b></div></article>
  <article><span>▣</span><div><small>آخرین انتشار</small><b>{{ $articles->first()?jdate_fa($articles->first()->published_at,'m/d'):'—' }}</b></div></article>
</div>

<div class="admin-content-grid">
  <section class="admin-card admin-editor-card">
    <div class="admin-card-head"><div><h3>انتشار مقاله جدید</h3><p>محتوای جدید برای وب‌سایت فولادینو ایجاد کنید.</p></div></div>
    <form class="stack-form" method="post" action="{{ route('admin.articles.store') }}">@csrf
      <label>عنوان مقاله<input name="title" placeholder="عنوان مقاله" required></label>
      <div class="form-grid">
        <label>Slug<input name="slug" placeholder="اختیاری"></label>
        <label>تاریخ انتشار<input name="published_at" value="{{ jdate_fa(now(),'Y/m/d H:i') }}"></label>
      </div>
      <label>خلاصه<textarea name="excerpt" rows="3" placeholder="خلاصه کوتاه برای کارت مقاله"></textarea></label>
      <label>متن مقاله<textarea name="body" rows="10" placeholder="متن کامل مقاله"></textarea></label>
      <label>تصویر شاخص<input name="image" value="/images/article-market.svg"></label>
      <label class="check-line"><input type="checkbox" name="is_published" value="1" checked> انتشار بلافاصله</label>
      <button class="btn btn-primary">انتشار مقاله</button>
    </form>
  </section>

  <section class="admin-card">
    <div class="admin-card-head">
      <div><h3>آرشیو محتوا</h3><p>{{ fa_digits($articles->count()) }} مقاله ثبت‌شده</p></div>
      <div class="admin-table-search"><span>⌕</span><input data-content-search placeholder="جستجو در مقالات..."></div>
    </div>
    <div class="content-list content-list-v2" data-content-list>
      @forelse($articles as $a)
      <article data-content-text="{{ $a->title }} {{ $a->excerpt }}">
        <img src="{{ $a->image }}" alt="">
        <div>
          <span class="status-badge {{ $a->is_published?'won':'contacted' }}">{{ $a->is_published?'منتشرشده':'پیش‌نویس' }}</span>
          <b>{{ $a->title }}</b>
          <small>{{ jdate_fa($a->published_at,'Y/m/d H:i') }}</small>
          <p>{{ $a->excerpt }}</p>
        </div>
        <form method="post" action="{{ route('admin.articles.destroy',$a) }}" onsubmit="return confirm('این مقاله حذف شود؟')">@csrf @method('DELETE')<button class="icon-btn danger">حذف</button></form>
      </article>
      @empty
      <div class="admin-empty">هنوز مقاله‌ای ثبت نشده است.</div>
      @endforelse
    </div>
  </section>
</div>
@endsection