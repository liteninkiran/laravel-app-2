<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Mail\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Post $post, Request $request)
    {
        $user = $request->user();

        if($post->likedBy($user))
        {
            return response(null, 409);
        }

        $post->likes()->create(['user_id' => $user->id]);

        // Check number of times user has previously liked post
        if(!$post->likes()->onlyTrashed()->where('user_id', $request->user()->id)->count())
        {
            // Do not self-notify
            if($post->user->id != $request->user()->id)
            {
                Mail::to($post->user)->send(new PostLike($user, $post));
            }
        }

        return back();
    }

    public function destroy(Post $post, Request $request)
    {
        $request->user()->likes()->where('post_id', $post->id)->delete();
        return back();
    }
}
