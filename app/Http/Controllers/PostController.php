<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $posts = Post::with('user', 'likes')->paginate(10);

        return view('posts.index', ['posts' => $posts]);
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
