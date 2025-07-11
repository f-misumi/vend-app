@if($products->count())
    @php
        $currentSort = request('sort', 'id');
        $currentDirection = request('direction', 'desc');
        function sortUrl($column, $currentSort, $currentDirection) {
            $direction = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';
            return request()->fullUrlWithQuery(['sort' => $column, 'direction' => $direction]);
        }
    @endphp
    <table>
        <thead>
            <tr>
                <th><a href="{{ sortUrl('id', $currentSort, $currentDirection) }}">ID</a></th>
                <th class="no-hover">商品画像</th>
                <th><a href="{{ sortUrl('product_name', $currentSort, $currentDirection) }}">商品名</a></th>
                <th><a href="{{ sortUrl('price', $currentSort, $currentDirection) }}">価格</a></th>
                <th><a href="{{ sortUrl('stock', $currentSort, $currentDirection) }}">在庫数</a></th>
                <th><a href="{{ sortUrl('company_name', $currentSort, $currentDirection) }}">メーカー名</a></th>
                <th class="no-hover">
                    <a href="{{ route('products.create') }}" class="button button_primary">新規登録</a>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr id="product-row-{{ $product->id}}">
                    <td class="col-narrow">{{ $product->id }}</td>
                    <td class="image_cell">
                        @if ($product->img_path)
                            <img src="{{ asset('storage/images/' . $product->img_path) }}" alt="商品画像" class="product_image">
                        @else
                            <span>No Image</span>
                        @endif
                    </td>
                    <td>{{ $product->product_name }}</td>
                    <td class="col-narrow">￥{{ number_format($product->price) }}</td>
                    <td class="col-narrow">{{ $product->stock }}</td>
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
                                <div class="modal_footer">
                                    <button type="button" class="button button_cancel" onclick="closeDeleteModal({{ $product->id }})">キャンセル</button>
                                    <button type="submit" class="button button_danger confirm-delete-button" data-id="{{ $product->id }}">削除する</button>
                                </div>
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
@else
    <p>該当する商品は見つかりませんでした。</p>
@endif
