<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class RegisterController extends Controller
{
    public function index()
    {
       return view('register');
    }

    public function registerUser(Request $request)
    {
        request()->validate([
            'user_name' => 'required',
            'password' => 'required',
        ]);

        $data=$request->input();
        $user = new User;
        $user->name=$data['user_name'];
        $user->password=$data['password'];
        $user->email=$data['email'];
        $user->save();
        auth()->login($user);

        return redirect()->route('index');
    }
}
