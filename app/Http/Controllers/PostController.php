<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index');
    }

    public function store(Request $request)
    {
        // Validate
        $validationRules =
        [
            'body' => 'required'
        ];

        $this->validate($request, $validationRules);

        // Create post
/*
        $data =
        [
            'user_id' => auth()->user()->id,
            'body' => $request->body
        ];

        Post::create($data);
*/
        auth()->user()->posts()->create($request->only('body'));

        return back();
    }
}
