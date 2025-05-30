<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー新規登録画面</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    @vite('resources/css/auth.css')
</head>
<body>
    <div class="auth_container">
        <h1>ユーザー新規登録画面</h1>

        <form class="form_container" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form_group">
                <div class="form_line">
                    <label for="name">ユーザー名</label>
                    <input id="name" type="name" name="name" value="{{ old('name') }}" required autofocus>
                </div>

                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form_group">
                <div class="form_line">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form_group">
                <div class="form_line">
                    <label for="password">パスワード</label>
                    <input id="password" type="password" name="password" required>
                </div>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form_group">
                <div class="form_line">
                    <label for="password_confirmation">パスワード（確認用）</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>
            </div>

            <div class="button_group">
                <button type="button" class="button button_secondary" onclick="location.href='{{ route('login') }}'">戻る</button>
                <button type="submit" class="button button_primary">新規登録</button>
            </div>
        </form>
    </div>
</body>
</html>
