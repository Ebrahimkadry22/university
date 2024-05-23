<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{


    public function allCourse()
    {
        $course = Course::all();
        if ($course == null) {
            return response()->json([
                'data' => 'There are no professors'
            ], 200);
        }
        return response()->json([
            'data' => $course
        ], 200);
    }


    public function addCourse (Request $request) {
        $validator = Validator::make($request->all() , [
            'title'=> 'required|string|min:10|max:200',
            'department_id'=> 'required|exists:departments,id'
        ]);

        if($validator->fails()) {
            return response()->json([
                'error'=> $validator->errors()
            ], 422);
        }
        $cousre = Course::create([
            'title'=> $request->title,
            'department_id' => $request->department_id
        ]);

        if($cousre) {
            return response()->json([
                'message' => 'successfuly add cousre'
            ], 200);
        }
        return response()->json([
            'error' => ' error in operations '
        ], 400);

    }

    public function update (Request $request) {

        $validator = Validator::make($request->all(),[
            'id'=> 'required|exists:courses,id'
        ]);

        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ],422);
        }

        $cousre = Course::find($request->id);

        if($cousre) {
            $cousre->update([
                'title' =>  $request->title,
                'department_id' => $request->department_id
            ]);
            return response()->json([
                'message' => 'successfuly Update cousre'
            ], 200);
        }

        return response()->json([
            'message' => 'error in operations '
        ], 422);

    }

    public function delete ($id) {
        $cousre = Course::where('id',$id)->delete();
        if($cousre) {
            return response()->json([
                'message' => 'successfuly delete cousre'
            ], 200);
        }
        return response()->json([
            'error' => 'cousre does not exist'
        ], 422);
    }
}
