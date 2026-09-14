<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class BookController extends Controller
{
    public function index()
    {
        $books=[
            [
                'title'=>'Laravel Beginner',
                'author'=>'Taylor',
                'category'=>'Programming',
                'price'=>350
            ],
            [
                'title'=>'PHP Programming',
                'author'=>'Somchai',
                'category'=>'Programming',
                'price'=>290
            ],
            [
                'title'=>'CSS Design',
                'author'=>'John',
                'category'=>'Web Design',
                'price'=>420
            ],
        ];
        return view('book',compact('books'));
    }
    public function store(Request $request)
    {
        return redirect()->route('book')->with('success','เพิ่มข้อมูลหนังสือเรียบร้อย');
    }
}