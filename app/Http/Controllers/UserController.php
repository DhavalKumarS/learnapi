<?php

namespace App\Http\Controllers;

use App\Http\Requests\Loginrequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {   
        $user = User::create([   
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password'),
        ]);

        Auth::login($user);

        return redirect('homepage')->with('status','Login succsessfully');
    }
}
