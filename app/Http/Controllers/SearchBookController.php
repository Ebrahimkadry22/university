<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SearchBookController extends Controller
{
    public function index (Request $request ) {
        $title = $request->title;
        $books= Book::get();
        $categroy = $request->categroy;
        if(!empty($title)) {
                $books = Book::where(function ($query) use ($title) {
                    $query->where('title','like','%'.$title.'%');
                })->get();
        }
        if(!empty($categroy)) {
                $books = Book::where(function ($query) use ($categroy) {
                    $query->where('categroy','like','%'.$categroy.'%');
                })->get();
        }


        return response()->json([
            'data' => $books
        ], 200);
    }
}
