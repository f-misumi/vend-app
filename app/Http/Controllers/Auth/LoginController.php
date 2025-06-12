<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $redirectTo = '/products';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // ログイン画面表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ログイン処理
    public function login(LoginRequest $request)
    {
        // バリデーション済みデータを取得
        $validated = $request->validated();

        if (Auth::attempt($validated)) {
            return redirect()->intended($this->redirectTo);
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ])->withInput();
    }

    // ログアウト処理
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
