@extends('layouts.app')
@section('content')
<main class="container page-shell"><div class="page-heading"><h1>سبد خرید</h1><p>محصولات، وزن و مبلغ سفارش خود را بررسی کنید.</p></div>
@if($products->isEmpty())<div class="empty-state">سبد خرید شما خالی است. <a href="{{ route('products') }}">مشاهده محصولات</a></div>
@else
<div class="cart-list">@foreach($products as $product)<article class="cart-item"><img src="{{ $product->image }}" alt=""><div><h3>{{ $product->name }}</h3><small>{{ $product->factory?->name }}</small><p>{{ fa_digits($cart[$product->id]) }} تن × {{ money_fa($product->price) }} تومان</p></div><strong>{{ money_fa((int)($cart[$product->id] * 1000 * $product->price)) }} تومان</strong><form method="post" action="{{ route('cart.remove',$product) }}">@csrf @method('delete')<button class="btn btn-outline">حذف</button></form></article>@endforeach</div>
<a class="btn btn-primary btn-lg" href="{{ route('checkout') }}">ادامه و محاسبه حمل ←</a>
@endif</main>
@endsection
