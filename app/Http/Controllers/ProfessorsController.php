<?php

namespace App\Http\Controllers;

use App\Models\Professors;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfessorsController extends Controller
{


    public function allProfessors()
    {
        $professors = Professors::all();
        if ($professors == null) {
            return response()->json([
                'data' => 'There are no professors'
            ], 200);
        }
        return response()->json([
            'data' => $professors
        ], 200);
    }

    public function addProfessor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:10|max:200',
            'phone' => 'required|string|min:11',
            'email' => 'required|string|unique:professors,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $professor = Professors::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        if ($professor) {
            return response()->json([
                'message' => 'successfuly add professor'
            ], 200);
        }

        return response()->json([
            'error' => 'error in operations '
        ], 422);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:Professors,id',
            'name' => 'required|string|min:10|max:200',
            'phone' => 'required|string|min:11',
            'email' => 'required|string|unique:professors,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $cousre = Professors::find($request->id);

        if ($cousre) {
            $cousre->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
            return response()->json([
                'message' => 'successfuly Update Professor'
            ], 200);
        }

        return response()->json([
            'message' => 'error in operations '
        ], 422);
    }

    public function delete ($id) {
        $cousre = Professors::where('id',$id)->delete();
        if($cousre) {
            return response()->json([
                'message' => 'successfuly delete Professors'
            ], 200);
        }
        return response()->json([
            'error' => 'Professors does not exist'
        ], 422);
    }
}
