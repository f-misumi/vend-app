<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', '商品管理システム')</title>

    {{-- 共通フォント --}}
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">

    {{-- ページごとの追加CSS --}}
    @stack('styles')

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- 共通JS --}}
    @vite('resources/js/script.js')
</head>
<body>
    {{-- 商品登録・更新・削除成功時モーダル --}}
    @if (session('success'))
    <div id="successModal" class="modal is-visible">
        <div class="modal_content">
            <p>{{ session('success') }}</p>
            <button class="modal_close" id="closeModal">閉じる</button>
        </div>
    </div>
    @endif

    {{-- 商品登録・更新・削除エラー時モーダル --}}
    @if (session('error'))
    <div id="errorModal" class="modal is-visible">
        <div class="modal_content error">
            <p>{{ session('error') }}</p>
            <button class="modal_close error" id="closeErrorModal">閉じる</button>
        </div>
    </div>
    @endif

    {{-- ヘッダー（ログイン中のナビなど）を必要に応じてここに挿入 --}}

    <main>
        @yield('content')
    </main>

    {{-- ページごとの追加JS --}}
    @stack('scripts')
</body>
</html>
