<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make( $request->all(), [
            'name'=> 'required|string|max:255',
            'email'=> 'required|email|max:255',
            'password'=> 'required|string|min:5|max:25|confirmed',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('Register-Token');
        return ['Token' => $token->plainTextToken];

    }

    public function login(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'email'=> 'required|email|max:255',
            'password'=> 'required|string|min:5|max:25',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $token = $user->createToken('Login-Token');
            return ['Token' => $token->plainTextToken];
            return response()->json([
                'Token' => $token->plainTextToken,
            ]);

           } 
        else{ 
            return response()->json(['error' => 'Unauthorised']);
        } 
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $request->user()->currentAccessToken()->delete();
    }




}
