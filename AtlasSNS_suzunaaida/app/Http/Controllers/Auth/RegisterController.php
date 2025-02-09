<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class RegisterController extends Controller
{
    // 新規ユーザー登録フォームを表示する
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    // ユーザーを登録する処理
    public function register(Request $request)
    {
        // バリデーションの実行
        $this->validator($request->all())->validate();

        // ユーザーの作成
        $user = $this->create($request->all());

        // セッションにユーザー名を保存
        $request->session()->put('username', $user->username);

        // ログインさせる処理
        auth()->login($user);

        // 登録後のリダイレクト先
        return redirect()->route('added');
    }

    // 入力のバリデーション
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'min:2', 'max:12'],
            'email' => ['required', 'string', 'email', 'min:5', 'max:40', 'unique:users'],
            'password' => ['required', 'alpha_num', 'min:8', 'max:20', 'confirmed'],
            'icon_image' => ['nullable', 'string'],
        ], [
            'required' => ':attribute は必須項目です。',
            'email' => ':attribute は正しい形式で入力してください。',
            'min' => ':attribute は最低 :min文字以上で入力してください。',
            'max' => ':attribute は最大 :max文字までです。',
            'alpha_num' => ':attribute は英数字のみで入力してください。',
            'unique' => 'この :attribute はすでに登録されています。',
            'confirmed' => ':attribute が確認用と一致しません。',
        ], [
            'username' => 'ユーザー名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'icon_image' => 'アイコン画像',
        ]);
    }

    // 新規ユーザーデータベースに保存
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'icon_image' => $data['icon_image'] ?? 'icon1.png',
        ]);
    }

    public function added(): View
    {
        return view('auth.added');
    }
}
