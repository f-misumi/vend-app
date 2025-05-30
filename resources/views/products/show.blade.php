<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品情報詳細画面</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    @vite('resources/css/product.css')
    @vite('resources/js/script.js')
</head>
<body>
    <div class="container">
        <h1>商品情報詳細画面</h1>

        <div class="product_detail">
            <div class="product_row"><span class="label">ID</span><span class="value">{{ $product->id }}</span></div>

            <div class="product_row">
                <span class="label">商品画像</span>
                    @if ($product->img_path)
                        <span class="value">
                            <img src="{{ asset('storage/images/' . $product->img_path) }}" alt="商品画像" class="product_image">
                        </span>
                    @else
                        <span class="value">No Image</span>
                    @endif
                </div>

            <div class="product_row"><span class="label">商品名</span><span class="value">{{ $product->product_name }}</span></div>
            <div class="product_row"><span class="label">メーカー</span><span class="value">{{ $product->company->company_name }}</span></div>
            <div class="product_row"><span class="label">価格</span><span class="value">¥{{ number_format($product->price) }}</span></div>
            <div class="product_row"><span class="label">在庫数</span><span class="value">{{ $product->stock }}</span></div>
            <div class="product_row"><span class="label">コメント</span><span class="value">{{ $product->comment }}</span></div>
        </div>

        <div class="button_group">
            <a href="{{ route('products.index') }}" class="button button_secondary">戻る</a>
            <a href="{{ route('products.edit', $product->id) }}" class="button button_primary">編集</a>
        </div>
    </div>
</body>
</html>

