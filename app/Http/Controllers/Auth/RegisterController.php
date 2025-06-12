<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 新規登録画面表示
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * 登録処理
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $this->create($validated);

        return redirect($this->redirectTo)->with('status', '登録が完了しました。');
    }

    /**
     * ユーザー作成
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
