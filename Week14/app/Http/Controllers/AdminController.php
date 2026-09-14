<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class AdminController extends Controller
{
    function blog()
    {
        $blogs = Blog::orderBy('id')->paginate(10);

        return view('blog', compact('blogs'));
    }

    function delete($id)
    {
        Blog::findOrFail($id)->delete();
        return redirect()->back();
    }

    function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view("edit", compact('blog'));
    }

    function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $data = $request->validate(
            [
                'title' => 'required|string|max:50',
                'content' => 'required|string',
                'status' => 'required|in:active,inactive',
            ],
            [
                'title.required' => 'กรุณากรอกชื่อบทความ',
                'title.max' => 'ชื่อบทความต้องไม่เกิน 50 ตัวอักษร',
                'content.required' => 'กรุณากรอกเนื้อหาบทความ',
                'status.required' => 'กรุณากรอกสถานะบทความ',
            ],
        );

        $blog->update($data);

        return redirect('/author/blog');
    }

    function about()
    {
        $data = [
            'name' => 'Atikan Khotmongkol',
            'city' => 'Ubon Ratchathani',
        ];

        return view('about', $data);
    }

    function insert(Request $request)
    {
        $data = $request->validate(
            [
                'title' => 'required|string|max:50',
                'content' => 'required|string',
                'status' => 'required|in:active,inactive',
            ],
            [
                'title.required' => 'กรุณากรอกชื่อบทความ',
                'title.max' => 'ชื่อบทความต้องไม่เกิน 50 ตัวอักษร',
                'content.required' => 'กรุณากรอกเนื้อหาบทความ',
                'status.required' => 'กรุณากรอกสถานะบทความ',
            ],
        );

        Blog::create($data);

        return redirect('/author/blog');
    }

    function form()
    {
        return view('form');
    }

    function changestatus(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->status === 'active') {
            $status = 'inactive';
        } else {
            $status = 'active';
        }

        $blog->update(['status' => $status]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'status' => $status]);
        }

        return redirect('/author/blog');
    }

    function __construct()
    {
        $this->middleware('auth');
    }
}
