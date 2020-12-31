<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
/*
    public function __construct()
    {
        $this->middleware(['auth']);
    }
*/
    public function index()
    {
        // Eager loading: with('user', 'likes')
        // Latest: orderBy('created_at', 'DESC')
        $posts = Post::latest()->with('user', 'likes')->paginate(10);

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

    public function destroy(Post $post)
    {
        // Use policy to check if user is allowed to delete the post (i.e. must be user's own post)
        $this->authorize('delete', $post);
        $post->delete();
        return back();
    }
}
