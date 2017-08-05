<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $this->validate($request, [
          'email' => 'required',
          'password' => 'required|min:2',
        ]);

        $username = $request->email;
        $password = $request->password;

        if (User::check_ec_auth($username, $password)) {
            $password = 'password';
            if (Auth::attempt(['email' => $username, 'password' => $password, 'family_member' => '0'])) {
                return redirect()->intended('/profile/'.Auth::user()->id);
            } else {
                return redirect()->back()->withInput($request->only('email'));
            }
        } else {
            if (Auth::attempt(['email' => $username, 'password' => $password, 'family_member' => '1'])) {
                return redirect()->intended('/profile/'.Auth::user()->id);
            } else {
                return redirect()->back()->withInput($request->only('email'));
            }
        }
    }
}
