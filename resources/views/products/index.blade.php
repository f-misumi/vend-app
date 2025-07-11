@extends('layouts.app')

@section('title', '商品一覧画面')

@push('styles')
    @vite('resources/css/index.css')
@endpush

@section('content')
    <div class="container">
        <h1>商品一覧画面</h1>

        <form method="GET" action="{{ route('products.index') }}" class="product_form-search" id="search-form">
            <div class="form_row-top">
                {{-- 商品名 --}}
                <div class="form_field-keyword">
                    <label for="keyword">商品名</label>
                    <input type="text" id="keyword" name="keyword" placeholder="商品名で検索" value="{{ request('keyword')}}">
                </div>
                {{-- 企業 --}}
                <div class="form_field-company">
                    <label for="company_id">企業</label>
                    <select name="company_id" id="company_id">
                        <option value="">選択してください</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name}}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="form_row-bottom">
                {{-- 価格 --}}
                <div class="form_field-price">
                    <label>価格</label>
                    <div class="form_range-group">
                        <input type="number" name="price_min" placeholder="最小価格" value="{{ request('price_min')}}">
                        <span>〜</span>
                        <input type="number" name="price_max" placeholder="最大価格" value="{{ request('price_max')}}">
                    </div>
                </div>
                {{-- 在庫 --}}
                <div class="form_field-stock">
                    <label>在庫数</label>
                    <div class="form_range-group">
                        <input type="number" name="stock_min" placeholder="最小在庫数" value="{{ request('stock_min')}}">
                        <span>〜</span>
                        <input type="number" name="stock_max" placeholder="最大在庫数" value="{{ request('stock_max')}}">
                    </div>
                </div>
                <div class="form_field-button">
                    <label>&nbsp;</label>
                    <button type="submit" class="form_button-search">検索</button>
                </div>
            </div>
        </form>

        <div id="product-list">
            @include('products.partials.product_table')
        </div>
    </div>
@endsection
