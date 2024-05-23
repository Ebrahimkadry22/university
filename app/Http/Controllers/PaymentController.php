<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function allCourses () {
        $payment = Payment::get();
        if($payment === null) {
            return response()->json([
                'data'=> 'payment does not exist'
            ],200);
        }
        return response()->json([
            'data' => $payment
        ],200);
    }

    public function addteach (Request $request) {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|min:3|max:200',

        ]);
        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ],422);
        }


        $payment = Payment::create([
            'type' => $request->type,

        ]);

        if($payment) {
            return response()->json([
                'message' => 'successfuly add'
            ],200);
        }
        return response()->json([
            'message' => 'error in operations'
        ],422);
    }




    public function delete ($id) {
        $cousre = Payment::where('id',$id)->delete();
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
