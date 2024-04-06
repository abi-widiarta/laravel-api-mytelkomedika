<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\Events\Registered;


class RegisterController extends Controller
{
    public function index() {
        return "index register";
    }

  

    public function storeAdmin(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'username' => 'required|min:3|max:15|unique:patients',
            'email' => 'required|max:50|unique:patients|email:dns,rfc',
            'password' => 'required|max:15|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        Admin::create($validatedData);

        return redirect('/admin/login');
    }
}
