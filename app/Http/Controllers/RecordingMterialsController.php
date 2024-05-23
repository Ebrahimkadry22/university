<?php

namespace App\Http\Controllers;

use App\Models\RecordingMterials;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Mockery\ReceivedMethodCalls;

class RecordingMterialsController extends Controller
{

    public function all () {
        $recoding = RecordingMterials::with('student','professor','course')->get();
        if($recoding === null) {
            return response()->json([
                'data'=> 'recoding does not exist'
            ],200);
        }
        return response()->json([
            'data' => $recoding
        ],200);
    }


    public function add(Request $request) {
        $studentId = $request['student_id'] = Auth()->guard('student')->id();

        $validator = Validator::make($request->all(),[
            'professor_id' => 'required|exists:professors,id',
            'course_id' => 'required|exists:courses,id',
        ]);
        if($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()
            ],422);
        }
        // $find = RecordingMterials::where(['student_id'=> $studentId ,'course_id'=> $request->course_id]);
        // if($find) {
        //     return response()->json([
        //         'message' => 'The act was recorded'
        //     ],200);
        // }

        $recoding = RecordingMterials::create([
            'student_id' => $studentId,
            'professor_id' => $request->professor_id,
            'course_id' => $request->course_id
        ]);

        if($recoding) {
            return response()->json([
                'message' => 'successfuly add'
            ],200);
        }
        return response()->json([
            'error' => 'error in operations '
        ], 422);
    }



    public function delete ($id) {
        $cousre = RecordingMterials::where('id',$id)->delete();
        if($cousre) {
            return response()->json([
                'message' => 'successfuly delete '
            ], 200);
        }
        return response()->json([
            'error' => 'Mterial does not exist'
        ], 422);
    }
}
