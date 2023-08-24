<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthViewController extends Controller
{
    //

    public function adminLogin() {
        return view('admin.auth.login');
    }

    public function adminRegister(){
        return view('admin.auth.register');
    }
}
