<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    //
    public function userRegister(Request $request) {

        $check = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirmed_password' => 'required|min:8|same:password'
        ]);

        if ($check->fails()){
            return response(['errors'=>$check->errors()->all()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('user')->accessToken;

        return response(['token' => $token]);
    }

    public function userLogin(Request $request) {
        $check = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($check->fails()){
            return response(['errors'=>$check->errors()->all()], 422);
        }

        if(!auth()->attempt($request->all())) {
            return response(['error' => 'Incorrect Details.
            Please try again']);
        }

        $token = auth()->user()->createToken('user')->accessToken;

        return response(['token' => $token]);
    }

    public function userLogout(Request $request) {
        // $accessToken = $request->user()->token();
        // $accessToken->revoke();
        if(Auth::guard('api')->check()) {
            $token = Auth::guard('api')->user()->token()->delete();
            // \DB::table('oauth_refresh_tokens')
            // ->where('access_token_id', $token->id)
            // ->update(['revoke' => true]);
            // $token->revoke();

            return response()->json(['message' => 'logout successfully']);
        }
        return response()->json(['message' => 'unauthorized']);
    }
}
