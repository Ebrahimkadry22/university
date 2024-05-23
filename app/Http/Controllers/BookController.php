<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function allBook () {
        $book = Book::get();
        if($book === null) {
            return response()->json([
                'data'=> 'Book does not exist'
            ],200);
        }
        return response()->json([
            'data' => $book
        ],200);
    }

    public function addBook (Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:200',
            'Author' => 'required|string|min:3|max:200',
            'status' => 'required|in:0,1',

        ]);
        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ],422);
        }


        $book = Book::create([
            'title' => $request->title,
            'Author' => $request->Author,
            'status' => $request->status,

        ]);

        if($book) {
            return response()->json([
                'message' => 'successfuly add'
            ],200);
        }
        return response()->json([
            'message' => 'error in operations'
        ],422);
    }




    public function delete ($id) {
        $cousre = Book::where('id',$id)->delete();
        if($cousre) {
            return response()->json([
                'message' => 'successfuly delete '
            ], 200);
        }
        return response()->json([
            'error' => 'Book does not exist'
        ], 422);
    }
}
