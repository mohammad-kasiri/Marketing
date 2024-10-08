<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function form()
    {
      //  \auth()->loginUsingId(1);
        return view('auth.login.login');
    }

    public function login(LoginRequest $request)
    {
        $user = User::query()->where('mobile', $request->username)
            ->orWhere('email', $request->username)->first();


        if (!$user or !Hash::check($request->password, $user->password) or !$user->is_active) {
            throw ValidationException::withMessages([
                'password' => __('auth.login.messages.failed')
            ]);
        }

        Auth::login($user,  $request->has('remember'));

        if($user->level == 'admin')
        {
            return redirect()->route('admin.index');
        }else {
            return redirect()->route('agent.index');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
