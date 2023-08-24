<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    //
    public function adminRegister(Request $request)
    {

        $check = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirmed_password' => 'required|min:8|same:password'
        ]);

        if ($check->fails()) {
            return redirect()->back()->withErrors($check)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        event(new Registered($user));
        Auth::login($user);

        // $token = $user->createToken('user')->accessToken;

        return redirect()->route('admin.index')->with(['message' => 'Register Successfully.']);
    }

    public function adminLogin(Request $request)
    {
        $check = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($check->fails()) {
            // return response(['errors'=>$check->errors()->all()], 422);
            return redirect()->back()->withErrors($check)->withInput();
        }

        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            // return response(['error' => 'Incorrect Details.
            // Please try again']);
            // Session::flash('message', 'This is a message!');
            return redirect()->back()->with(['error' => 'Incorrect Details.
            Please try again'])->withInput();
        }

        // $token = auth()->user()->createToken('user')->accessToken;

        $request->session()->regenerate();

        return redirect()->route('admin.index')->with(['message' => 'Login Successfully.']);
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with(['message' => 'Logout Successfully.']);
    }
}
