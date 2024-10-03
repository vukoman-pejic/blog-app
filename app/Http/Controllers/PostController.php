<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{

    use AuthorizesRequests;

    // List all posts
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    // Show the form to create a new post
    public function create()
    {
        return view('posts.create');
    }

    // Validate and save the post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        // Create a new post associated with the authenticated user
        $request->user()->posts()->create($request->all());

        return redirect('/posts')->with('success', 'Post created successfully.');
    }

    // Display a single post with its comments
    public function show($id)
    {
        $post = Post::with('comments')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    // Show the form to edit a post (only if the user owns it)
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Check if the authenticated user is the owner of the post
        $this->authorize('edit', $post);

        return view('posts.edit', compact('post'));
    }

    // Validate and update the post
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post = Post::findOrFail($id);

        // Check if the authenticated user is the owner of the post
        $this->authorize('update', $post);

        // Update the post with validated data
        $post->update($request->all());

        return redirect('/posts')->with('success', 'Post updated successfully.');
    }

    // Delete the post (only the owner)
    public function delete($id)
    {
        $post = Post::findOrFail($id);

        // Check if the authenticated user is the owner of the post
        $this->authorize('delete', $post);

        // Delete the post
        $post->delete();

        return redirect('/posts')->with('success', 'Post deleted successfully.');
    }
}
