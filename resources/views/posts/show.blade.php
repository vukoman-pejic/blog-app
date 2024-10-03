@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    
    <h3>Comments</h3>
    @foreach($post->comments as $comment)
        <div class="border p-2 mb-2">
            <strong>User {{ $comment->user_id }}:</strong>
            <p>{{ $comment->comment }}</p>
        </div>
    @endforeach

    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
</div>
@endsection
