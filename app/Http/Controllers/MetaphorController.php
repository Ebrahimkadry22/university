<?php

namespace App\Http\Controllers;

use App\Models\Metaphor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MetaphorController extends Controller
{

    public function allMetaphor()
    {
        $metaphor = Metaphor::with('student','book')->get();
        if ($metaphor == null) {
            return response()->json([
                'data' => 'There are no professors'
            ], 200);
        }
        return response()->json([
            'data' => $metaphor
        ], 200);
    }



    public function   metaphorBook (Request $request) {
        $studentId = $request['student_id'] = Auth::guard('student')->id();
        $validator = Validator::make($request->all() , [
            'book_id' => 'required|exists:books,id',
        ]);

        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ],422);
        }

        // $find = Metaphor::find(['student_id'=> $studentId , 'book_id'=>$request->book_id]);
        // if($find) {
        //     return response()->json([
        //         'message' => 'These books are borrowed'
        //     ],200);
        // }

        $book = Metaphor::create([
            'student_id'=>$studentId,
            'book_id'=>$request->book_id,
        ]);

        if($book) {
            return response()->json([
                'message' => 'Completely borrowed books successfully'
            ],200);
        }

        return response()->json([
            'error' => ' error in operations '
        ], 400);
    }

    public function delete ($id) {
        $metaphor = Metaphor::where('id',$id)->delete();
        if($metaphor) {
            return response()->json([
                'message' => 'successfuly delete '
            ], 200);
        }
        return response()->json([
            'error' => 'Book does not exist'
        ], 422);
    }
}
