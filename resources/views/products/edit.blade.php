<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品情報編集画面</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    @vite('resources/css/product.css')
    @vite('resources/js/script.js')
</head>
<body>
    {{-- 更新成功時モーダル表示 --}}
    @if (session('success'))
        <div id="successModal" class="modal is-visible">
            <div class="modal_content">
                <p>{{ session('success') }}</p>
                <button class="modal_close" id="closeModal">閉じる</button>
            </div>
        </div>
    @endif

    {{-- 更新失敗時モーダル表示 --}}
    @if (session('error'))
    <div id="errorModal" class="modal is-visible">
        <div class="modal_content error">
            <p>{{ session('error') }}</p>
            <button class="modal_close" id="closeErrorModal">閉じる</button>
        </div>
    </div>
    @endif

    <div class="container">
        <h1>商品情報編集画面</h1>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
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
                    <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
                </div>
            </div>

            <div class="form_group">
                <div class="form_line">
                    <label>メーカー<span class="required_mark">*</span></label>
                    <select name="company_id" class="form-select" required>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id', $product->company_id ?? '') == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form_group">
                <div class="form_line">
                    <label>価格<span class="required_mark">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required>
                </div>
            </div>

            <div class="form_group">
                <div class="form_line">
                    <label>在庫数<span class="required_mark">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required>
                </div>
            </div>


            <div class="form_group">
                <div class="form_line">
                    <label>コメント</label>
                    <textarea name="comment">{{ old('comment', $product->comment) }}</textarea>
                </div>
            </div>

            <div class="form_group">
                <div class="form_line">
                    <label for="img_path">商品画像</label>

                    <div class="image_file_wrapper">
                        @if (!empty($product->img_path))
                            <div class="image_wrapper">
                                <img src="{{ asset('storage/images/' . $product->img_path) }}" alt="登録済み画像" class="product_image">
                            </div>
                        @endif
                        <div class="file_wrapper">
                            <label class="file_button">
                                ファイルを選択
                                <input type="file" name="img_path" id="img_path" class="form_input-file" hidden>
                            </label>
                            <span id="file_name" class="file_name">選択されていません</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="button_group">
                <a href="{{ route('products.show', $product->id) }}" class="button button_secondary">戻る</a>
                <button type="submit" class="button button_primary">更新</button>
            </div>
        </form>
    </div>
</body>
</html>

