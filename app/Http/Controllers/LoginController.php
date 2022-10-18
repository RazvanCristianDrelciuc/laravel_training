<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Input;


class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('password');
//        dd($credentials);
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            dd($credentials);
            return redirect()->route('index');

//            return redirect()->intended('index');
        }
//        return redirect()->route('index');
    }

    public function authenticate2(Request $request)
    {
        $userdata = array(
            'name' => $request->input('name'),
            'password' => $request->input('password')
        );
       // dd(Auth::attempt($userdata), $userdata);
        if (Auth::attempt($userdata)) {
            return redirect()->route('index');
        } else {
            return redirect()->route('cart');
        }
    }
}
