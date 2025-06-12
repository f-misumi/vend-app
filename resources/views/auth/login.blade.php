<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザーログイン画面</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    @vite('resources/css/auth.css')
</head>
<body>
    <div class="auth_container">
        <h1>ユーザーログイン画面</h1>

        <form class="form_container" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form_group">
                <div class="form_line">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus>
                </div>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form_group">
                <div class="form_line">
                    <label for="password">パスワード</label>
                    <input id="password" type="password" name="password">
                </div>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="button_group">
                <button type="button" class="button button_secondary" onclick="location.href='{{ route('register') }}'">新規登録</button>
                <button type="submit" class="button button_primary">ログイン</button>
            </div>
        </form>
    </div>
</body>
</html>

