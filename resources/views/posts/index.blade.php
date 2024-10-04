@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Posts</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('posts.create') }}" class="bg-blue-500 text-black font-semibold py-2 px-4 rounded hover:bg-blue-600 mb-4 inline-block">Create New Post</a>

    <div>
        @foreach($posts as $post)
            <div class="bg-white shadow-md rounded-lg mb-4">
                <div class="p-4">
                    <h5 class="text-xl font-semibold mb-2">{{ $post->title }}</h5>
                    <p class="text-gray-700 mb-4">{{ Str::limit($post->content, 100) }}</p>
                    <a href="{{ route('posts.show', $post->id) }}" class="bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded hover:bg-gray-400">View</a>

                    @can('update', $post)
                        <a href="{{ route('posts.edit', $post->id) }}" class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded hover:bg-yellow-600">Edit</a>
                        <form action="{{ route('posts.delete', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white font-semibold py-2 px-4 rounded hover:bg-red-600">Delete</button>
                        </form>
                    @endcan
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
