<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function redirectTo()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return '/dashboard';
            } elseif (Auth::user()->role === 'user') {
                return '/user/dashboard';
            }
        }
        return '/login';
    }

    protected function authenticated(Request $request, $user)
    {
        $roleMessage = $user->role === 'admin' ? 'Anda sekarang sebagai admin.' : 'Anda sekarang sebagai user.';

        return redirect()->intended($this->redirectPath())->with('success', 'Login berhasil. ' . $roleMessage);
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
