<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //đăng nhập
    public function ShowLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
    //     $this->validate($request, [
    //        'email' =>'required|email',
    //        'password' => 'required|min:6'
    //    ]);
   $user = $request->validate([
    'email' => 'required|email',
    'password' => 'required|min:6'
   ]);

   if (auth()->attempt($user)) {
    return redirect()->intended('home');
   }
   return redirect()->back()->withErrors([ 'email' => 'Nhập sai thông tin người dùng']);
    }
    // đăng kí
    public function ShowRegistrationForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
     $user = User::query()->create($data);

     Auth::login($user);

     return redirect()->intended('home');
    }
    public function logout(Request $request)
    {
       Auth::logout();
       return redirect('/login');
}
}