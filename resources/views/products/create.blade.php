@extends('layouts.app')

@section('title', '商品新規登録画面')

@push('styles')
    @vite('resources/css/product.css')
@endpush

@section('content')
    <div class="container">
        <h1>商品新規登録画面</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- エラーメッセージ --}}
            @if ($errors->any())
                <div class="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="form_group">
                <div class="form_line">
                    <label>商品名<span class="required_mark">*</span></label>
                    <input type="text" name="product_name" value="{{ old('product_name') }}">
                </div>
            </div>

            <div class="form_group">
                <div class="form_line">
                    <label>メーカー<span class="required_mark">*</span></label>
                    <select name="company_id" class="form-select">
                        <option value="">選択してください</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form_group">
                <div class="form_line">
                    <label>価格<span class="required_mark">*</span></label>
                    <input type="number" name="price" value="{{ old('price') }}">
                </div>
            </div>

            <div class="form_group">
                <div class="form_line">
                    <label>在庫数<span class="required_mark">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock') }}">
                </div>
            </div>


            <div class="form_group">
                <div class="form_line">
                    <label>コメント</label>
                    <textarea name="comment">{{ old('comment') }}</textarea>
                </div>
            </div>

            <div class="form_group">
                <div class="form_line">
                    <label for="img_path">商品画像</label>

                    <div class="file_wrapper">
                        <label class="file_button">
                            ファイルを選択
                            <input type="file" name="img_path" id="img_path" class="form_input-file" hidden>
                        </label>
                        <span id="file_name" class="file_name">選択されていません</span>
                    </div>
                </div>
            </div>


            <div class="button_group">
                <a href="{{ route('products.index') }}" class="button button_secondary">戻る</a>
                <button type="submit" class="button button_primary">登録</button>
            </div>
        </form>
    </div>
@endsection

