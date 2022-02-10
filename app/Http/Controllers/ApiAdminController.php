<?php

namespace App\Http\Controllers;

use App\Http\Resources\JoggingTimeResource;
use App\Http\Resources\UserResource;
use App\Models\JoggingTime;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiAdminController extends Controller
{
    public function createUser(Request $request){
        $validator = Validator::make( $request->all(), [
            'name'=> 'required|string|max:255',
            'email'=> 'required|email|max:255',
            'role_id' => 'nullable|exists:roles,id',
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

    public function createRecord(Request $request){

        $validator = Validator::make( $request->all(), [
            'time_mins'=> 'required|numeric',
            'date'=> 'required|date',
            'distance'=> 'required|numeric|min:1|max:30',
            'user_id' => 'required|exists:users,id',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $joggingTimeData = JoggingTime::create([
            'time_mins' => $request->time_mins,
            'date' => $request->date,
            'distance' => $request->distance,
            'user_id' => $request->user_id,
        ]);
        return response()->json([
            'msg' => 'Created Successfully',
            'records' => new JoggingTimeResource($joggingTimeData),
        ]);

    }

    public function show(){
        $users = User::with('joggingTimes')->get();
        return UserResource::collection($users);
    }

    public function updateUser($userId, Request $request){
        $validator = Validator::make( $request->all(), [
            'name'=> 'required|string|max:255',
            'email'=> 'required|email|max:255',
            'role_id' => 'nullable|exists:roles,id',
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

    public function updateRecord($recordId, Request $request){
        $validator = Validator::make( $request->all(), [
            'time_mins'=> 'required|numeric',
            'date'=> 'required|date',
            'distance'=> 'required|numeric|min:1|max:30',
            'user_id' => 'required|exists:users,id',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $record = JoggingTime::find($recordId);

        if($record == null){
            return response()->json([
                'msg' => '404 not found'
            ]);
        }

        $record->update([
            'time_mins' => $request->time_mins,
            'date' => $request->date,
            'distance' => $request->distance,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'msg' => 'Udpated Successfully',
            'records' => new JoggingTimeResource($record),
        ]);
    }

    public function deleteRecord($recordId){

        $record = JoggingTime::find($recordId);

        if($record == null){
            return response()->json([
                'msg' => '404 not found'
            ]);
        }

        $record->delete();
        return response()->json([
            'msg' => 'Deleted Successfully',
        ]);
    }


}
