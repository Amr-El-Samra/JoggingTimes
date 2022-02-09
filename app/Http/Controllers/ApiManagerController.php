<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiManagerController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make( $request->all(), [
            'name'=> 'required|string|max:255',
            'email'=> 'required|email|max:255',
            'role_id' => ['nullable', Rule::exists('roles', 'id')->where('id','!3')],
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
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('Added-User-Token');
        
        return response()->json([
            'msg' => 'Created Successfully',
            'Token' => $token->plainTextToken,
        ]);
    }
    
    public function show(){
        $users = User::where('role_id', '<>', '3')->get();
        return UserResource::collection($users);
    }
    
    public function update($userId, Request $request){
        $validator = Validator::make( $request->all(), [
            'name'=> 'required|string|max:255',
            'email'=> 'required|email|max:255',
            'role_id' => ['nullable', Rule::exists('roles', 'id')->where('id','!3')],
            'password'=> 'required|string|min:5|max:25',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $user = User::find($userId);

        if($user == null){
            return response()->json([
                'msg' => '404 not found'
            ]);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'msg' => 'Udpated Successfully',
            'records' => new UserResource($user),
        ]);
    }

    public function deleteUser($userId){

        $user = User::find($userId);

        if($user == null){
            return response()->json([
                'msg' => '404 not found'
            ]);
        }
        $user->joggingTimes()->where('user_id', $userId)->delete();
        $user->delete();
        return response()->json([
            'msg' => 'Deleted Successfully',
        ]);
    }
}
