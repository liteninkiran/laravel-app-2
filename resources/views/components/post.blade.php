@props(['post' => $post])

<div>

    <div class="mb-4 p-2 @can('delete', $post) bg-yellow-100 rounded-xl @endcan">

        <a href="{{ route('users.posts', $post->user) }}" class="font-bold">{{ $post->user->name }}</a> <span class="text-gray-600 text-sm">{{ $post->created_at->diffForHumans() }}</span>
        <p class="mb-2"><pre class="font-sans">{{ $post->body }}</pre></p>
    
        <div class="flex items-center">
            <span><small>{{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}</small></span>
        </div>
    
        <div class="flex items-center">
    
            @auth
    
                @if (!$post->likedBy(auth()->user()))
    
                    <form action="{{ route('posts.likes', $post) }}" method="post" class="mr-1">
                        @csrf
                        <button type="submit" class="text-blue-500">Like</button>
                    </form>
    
                @else
    
                    <form action="{{ route('posts.likes', $post) }}" method="post" class="mr-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-blue-500">Unlike</button>
                    </form>
    
                @endif
    
            @endauth
    
        </div>

    </div>

    @can('delete', $post)
        <form action="{{ route('posts.destroy', $post) }}" method="post">
            @csrf
            @method('DELETE')
            <div class="flex justify-end">
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded font-medium mb-4">Delete</button>
            </div>
        </form>
    @endcan

</div>
