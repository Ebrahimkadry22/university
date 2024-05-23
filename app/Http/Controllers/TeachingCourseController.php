<?php

namespace App\Http\Controllers;

use App\Models\TeachingCourse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class TeachingCourseController extends Controller
{
    public function allCourses () {
        $courses = TeachingCourse::with('professor','course','department')->get(    );
        if($courses === null) {
            return response()->json([
                'data'=> 'cousre does not exist'
            ],200);
        }
        return response()->json([
            'data' => $courses
        ],200);
    }

    public function addteach (Request $request) {
        $validator = Validator::make($request->all(), [
            'professor_id' => 'required|exists:professors,id',
            'course_id' => 'required|exists:courses,id',
            'department_id' => 'required|exists:departments,id'
        ]);
        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ],422);
        }

        $find = TeachingCourse::where(['professor_id'=> $request->professor_id , 'course_id'=>$request->course_id]);
        if($find) {
            return response()->json([
                'message' => 'you is studying this'
            ],200);
        }
        $teach = TeachingCourse::create([
            'professor_id' => $request->professor_id,
            'course_id' => $request->course_id,
            'department_id' => $request->department_id,
        ]);

        if($teach) {
            return response()->json([
                'message' => 'successfuly add'
            ],200);
        }
        return response()->json([
            'message' => 'error in operations'
        ],422);
    }



    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id'=> 'required|exists:teaching_courses,id',
            'professor_id' => 'required|exists:professors,id',
            'course_id' => 'required|exists:courses,id',
            'department_id' => 'required|exists:departments,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $teach = TeachingCourse::find($request->id);

        if ($teach) {
            $teach->update([
                'professor_id' => $request->professor_id,
            'course_id' => $request->course_id,
            'department_id' => $request->department_id,
            ]);
            return response()->json([
                'message' => 'successfuly Update'
            ], 200);
        }

        return response()->json([
            'message' => 'error in operations '
        ], 422);
    }

    public function delete ($id) {
        $cousre = TeachingCourse::where('id',$id)->delete();
        if($cousre) {
            return response()->json([
                'message' => 'successfuly delete '
            ], 200);
        }
        return response()->json([
            'error' => 'Professors does not exist'
        ], 422);
    }

}
