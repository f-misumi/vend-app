@extends('layouts.app')

@section('title', '商品一覧画面')

@push('styles')
    @vite('resources/css/index.css')
@endpush

@section('content')
    <div class="container">
        <h1>商品一覧画面</h1>

        <form method="GET" action="{{ route('products.index') }}" class="product_form-search" id="search-form">
            {{-- 商品名 --}}
            <div class="form_field-keyword">
                <input type="text" name="keyword" placeholder="商品名で検索" value="{{ request('keyword')}}">
            </div>
            {{-- 企業 --}}
            <div class="form_field-company">
                <select name="company_id">
                    <option value="">選択してください</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->company_name}}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- 価格 --}}
            <div class="form_field-price">
                <input type="number" name="price_min" placeholder="最小価格" value="{{ request('price_min')}}">
                <input type="number" name="price_max" placeholder="最大価格" value="{{ request('price_max')}}">
            </div>
            {{-- 在庫 --}}
            <div class="form_field-stock">
                <input type="number" name="stock_min" placeholder="最小在庫数" value="{{ request('stock_min')}}">
                <input type="number" name="stock_max" placeholder="最大在庫数" value="{{ request('stock_max')}}">
            </div>
            <div class="form_field-button">
                <button type="submit" class="form_button-search">検索</button>
            </div>
        </form>

        <div id="product-list">
            @include('products.partials.product_table')
        </div>

        <div class="pagination_product-list">
            {{ $products->links() }}
        </div>
    </div>
@endsection

