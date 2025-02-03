<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
     public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        return response()->json([
            'messsage' => 'Thành công',
            'user' => $user
        ],201);
     }

     public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                'messsage' => 'Email hoặc mật khẩu k đúng',
            ],401);

        }
        
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'messsage' => 'đăng nhập thành công',
            'user' => $user,
            'token' => $token                
        ]);

     }

      // Đăng xuất
    public function logout(){
        log::debug(1);
die(1);
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'Đăng xuất thành công.']);
    }
}
