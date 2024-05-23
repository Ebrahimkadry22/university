<?php

namespace App\Http\Controllers;

use App\Models\UniversityCity;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UniversityCityController extends Controller
{

    public function allRoom() {
        $rooms = UniversityCity::with('student')->get();
        return response()->json([
            'data'=> $rooms
            ],200);
    }

    public function requestRoom (Request $request) {
        $studentId = $request['student_id'] = Auth()->guard('student')->id();
        $validator = Validator::make($request->all() , [
            'room_id'=> 'required|exists:rooms,id',
            'bed_id'=> 'required|exists:beds,id'
        ]);

        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ],422);
        }

        $universityCity = UniversityCity::create([
            'student_id' => $studentId,
            'room_id' => $request->room_id,
            'bed_id' => $request->bed_id,
        ]);

        if($universityCity) {
            return response()->json([
                'message' => 'successfuly request room '
            ],200);
        }
        return response()->json([
            'error' => 'error in operations '
        ], 422);
    }

    public function deleteRoom ($id) {
        $studentId = Auth::guard('student')->id();
        $room = UniversityCity::where(['id'=>$id , 'student_id'=>$studentId])->delete();
        if($room) {
            return response()->json([
                'message' => 'successfuly delete request room '
            ],200);
        }
        return response()->json([
            'error' => 'This request room does not exist'
        ],400);
    }

    public function updateStatus (Request $request) {
        $vaildator = Validator::make($request->all(),[
            'id'=> 'required|exists:university_cities,id',
            'status'=> 'required|in:approved,rejected',
        ]);
        if($vaildator->fails()) {
            return response()->json([
                'error' => $vaildator->errors()
            ],400);
        }

        $room = UniversityCity::find($request->id);
        if($room) {
            $room->update([
                'status' => $request->status
            ]);

            return  response()->json([
                'message' => 'successfuly status room'
            ], 200);
        }

        return  response()->json([
            'message' => 'This room does not exist'
        ], 400);
    }


}
