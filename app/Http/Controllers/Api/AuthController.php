<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function rigester(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return response()->json([
            'user' => $user,
            "message" => "user Register successfully"
        ],201);
        
    }
    public function login(Request $request){
           
     $request->validate([
          'email' => 'required|email',
          'password' => 'required'
     ]);
     if(!Auth::attempt($request->only('email','password'))){
    
            return response()->json(['message' => 'Invalid credentials'],401);
     }
     $user = User::where('email',$request->email)->first();
     $token = $user->createToken('api-token')->plainTextToken;
     
     return response()->json([
             'user' => $user,
             'token' => $token,
             'message' => 'seccssfully login'
     ],200);
     }


     public function logout(Request $request){
 
       $request->user()->tokens()->delete();
       return response()->json([
           'message' => 'seccssfully logout',
       ],200);     
    }
}
