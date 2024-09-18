<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        //Modificar el request

        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|email|unique:users|max:60',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        //Autenticar un usuario
        // Auth::attempt(
        //     [
        //         'email' => $request->email,
        //         'password' => $request->password
        //     ]
        // );

        //Otra forma de autenticar 
        Auth::attempt($request->only('email', 'password'));
        
        return redirect()->route('posts.index');
    }
}
