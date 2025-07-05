@extends('layouts.app')

@section('title', '商品一覧画面')

@push('styles')
    @vite('resources/css/index.css')
@endpush

@section('content')
    <div class="container">
        <h1>商品一覧画面</h1>

        <form method="GET" action="{{ route('products.index') }}" class="product_form-search">
            <div class="form_field-keyword">
                <input type="text" name="keyword" placeholder="商品名で検索" value="{{ request('keyword')}}">
            </div>
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
            <div class="form_field-button">
                <button type="submit" class="form_button-search">検索</button>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>メーカー名</th>
                    <th colspan="2">
                        <a href="{{ route('products.create') }}" class="button button_primary">新規登録</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td class="image_cell">
                            @if ($product->img_path)
                                <img src="{{ asset('storage/images/' . $product->img_path) }}" alt="商品画像" class="product_image">
                            @else
                                <span>No Image</span>
                            @endif
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>￥{{ number_format($product->price) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->company->company_name }}</td>
                        <td class="button_group">
                            {{-- 詳細ボタン --}}
                            <a href="{{ route('products.show', $product->id) }}" class="button button_detail">詳細</a>
                            {{-- 削除ボタン --}}
                            <button type="button" class="button button_delete" onclick="openDeleteModal({{ $product->id }})">削除</button>
                            {{-- 削除確認用モーダル --}}
                            <div id="deleteModal-{{ $product->id }}" class="modal" style="display: none;">
                                <div class="modal_content">
                                    <p>商品を削除しますか？</p>
                                    <form id="deleteForm-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal_footer">
                                            <button type="button" class="button button_cancel" onclick="closeDeleteModal({{ $product->id }})">キャンセル</button>
                                            <button type="submit" class="button button_danger">削除する</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8">登録された商品がありません。</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination_product-list">
            {{ $products->links() }}
        </div>
    </div>
@endsection

