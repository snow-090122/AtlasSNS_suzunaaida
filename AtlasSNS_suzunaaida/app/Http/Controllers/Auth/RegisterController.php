<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class RegisterController extends Controller
{
    //新規ユーザー登録フォームを表示する
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    //ユーザーを登録する処理
    public function register(Request $request)
    {
        //バリデーションの実行
        $this->validator($request->all())->validate();

        //ユーザーの作成
        $user = $this->create($request->all());

        //セッションにユーザを保存
        $request->session()->put('username', $user->all());

        //ログインさせる処理
        auth()->login($user);

        //登録後のリダイレクト先
        return redirect()->route('added');
    }

    //入力のバリデーション
    protected function validator(array $date)
    {
        return Validator::make($date, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'contirmed'],
        ]);
    }

    //新規ユーザーデータベースに保存
    protected function create(array $date)
    {
        return User::create([
            'username' => $date['username'],
            'email' => $date['email'],
            'password' => Hash::make($date['password']),
        ]);
    }

    public function added(): View
    {
        return view('auth.added');
    }
}
