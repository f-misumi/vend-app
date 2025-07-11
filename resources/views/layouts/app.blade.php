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

    {{-- CSRFトークン --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    {{-- ログイン・新規登録画面ではモーダルを非表示 --}}
    @php
        $hideModals = in_array(Route::currentRouteName(), ['login', 'register']);
    @endphp

    @if (!$hideModals)
        {{-- 商品登録・更新・削除成功時モーダル --}}
        <div id="successModal" class="modal {{ session('success') ? 'is-visible' : '' }}">
            <div class="modal_content">
                <p class="modal-content-message">
                    {{ session('success') ?? 'ここに成功メッセージが入ります' }}
                </p>
                <button class="modal_close" id="closeModal">閉じる</button>
            </div>
        </div>

        {{-- 商品登録・更新・削除エラー時モーダル --}}
        <div id="errorModal" class="modal {{ session('error') ? 'is-visible' : '' }}">
            <div class="modal_content error">
                <p class="modal-content-message">
                    {{ session('error') ?? 'ここにエラー内容が入ります' }}
                </p>
                <button class="modal_close error" id="closeErrorModal">閉じる</button>
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    {{-- ページごとの追加JS --}}
    @stack('scripts')
</body>
</html>
