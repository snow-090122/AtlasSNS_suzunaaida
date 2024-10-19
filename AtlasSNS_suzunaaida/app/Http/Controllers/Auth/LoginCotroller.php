<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/top';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {

            $data = $request->only('mail', 'password');

            $request->validate([
                'mail' => 'max:255|string|required|email',
                'password' => 'max:255|string|required',
            ]);

            if (Auth::attempt($data)) {
                return redirect('/top');
            } else {
                return back()->withErrors([
                    'error' => 'メールアドレスまたはパスワードが正しくありません。'
                ]);
            }
        }
        return view("auth.login");
    }
}
