@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    
    <h3>Comments</h3>
    @foreach($post->comments as $comment)
    <div class="card mb-3">
            <div class="card-body">
                <p>{{ $comment->comment }}</p>
                <small>Posted by {{ $comment->user->name }} on {{ $comment->created_at->format('d M Y') }}</small>

                <!-- Allow deletion if the logged-in user is the comment's owner -->
                @if(auth()->check() && auth()->id() === $comment->user_id)
                    <form action="{{ route('comments.delete', $comment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach

    <!-- Comment Form -->
    @auth
        <h3>Leave a Comment</h3>
        <form action="{{ route('comments.store', $post->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea name="comment" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
        </form>
    @else
        <p>Please <a href="{{ route('login') }}">login</a> to leave a comment.</p>
    @endauth

    <!-- <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a> -->
</div>
@endsection
