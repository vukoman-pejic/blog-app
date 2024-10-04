@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
    <p class="text-gray-700 mb-6">{{ $post->content }}</p>
    
    <h3 class="text-2xl font-semibold mb-4">Comments</h3>
    @foreach($post->comments as $comment)
    <div class="bg-white shadow-md rounded-lg mb-4">
        <div class="p-4">
            <p class="text-gray-800">{{ $comment->comment }}</p>
            <small class="text-gray-500">Posted by {{ $comment->user->name }} on {{ $comment->created_at->format('d M Y') }}</small>

            <!-- Allow deletion if the logged-in user is the comment's owner -->
            @if(auth()->check() && auth()->id() === $comment->user_id)
                <form action="{{ route('comments.delete', $comment->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white font-semibold py-1 px-2 rounded hover:bg-red-600">Delete</button>
                </form>  
            @endif
        </div>
    </div>
    @endforeach

    <!-- Comment Form -->
    @auth
        <h3 class="text-2xl font-semibold mb-4">Leave a Comment</h3>
        <form action="{{ route('comments.store', $post->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <textarea name="comment" class="border border-gray-300 rounded-lg w-full p-2" rows="4" required></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-black font-semibold py-2 px-4 rounded hover:bg-blue-600">Post Comment</button>
        </form>
    @else
        <p class="text-gray-600">Please <a href="{{ route('login') }}" class="text-blue-500 hover:underline">login</a> to leave a comment.</p>
    @endauth  
    
    <div class="mt-6">
        <a href="{{ route('posts.index') }}" class="bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded hover:bg-gray-400">Back to Posts</a>
    </div>
</div>
@endsection
