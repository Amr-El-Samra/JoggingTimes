<?php

namespace App\Http\Controllers;

use App\Http\Resources\JoggingTimeResource;
use App\Models\JoggingTime;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiUserController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make( $request->all(), [
            'time_mins'=> 'required|numeric',
            'date'=> 'required|date',
            'distance'=> 'required|numeric|min:1|max:30',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $user = Auth::user();
        $joggingTimeData = JoggingTime::create([
            'time_mins' => $request->time_mins,
            'date' => $request->date,
            'distance' => $request->distance,
            'user_id' => $user->id,
        ]);
        return response()->json([
            'msg' => 'Created Successfully',
            'records' => new JoggingTimeResource($joggingTimeData),
        ]);


    }

    public function show(Request $request){
        
        $query = Auth::user()->joggingTimes();
        if($request->from){
            $query->where('date', '>=', $request->from);
        }
        if($request->to){
            $query->where('date', '<=', $request->to);
        }
        $data = $query->get();
        return JoggingTimeResource::collection($data);

    }

    public function update($recordId, Request $request){
        $validator = Validator::make( $request->all(), [
            'time_mins'=> 'required|numeric',
            'date'=> 'required|date',
            'distance'=> 'required|numeric|min:1|max:30',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $user = Auth::user();
        $record = JoggingTime::where('user_id', $user->id)->find($recordId);

        if($record == null){
            return response()->json([
                'msg' => '404 not found'
            ]);
        }

        $record->update([
            'time_mins' => $request->time_mins,
            'date' => $request->date,
            'distance' => $request->distance,
        ]);

        return response()->json([
            'msg' => 'Udpated Successfully',
            'records' => new JoggingTimeResource($record),
        ]);
    }

    public function delete($recordId){

        $user = Auth::user();
        $record = JoggingTime::where('user_id', $user->id)->find($recordId);

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
