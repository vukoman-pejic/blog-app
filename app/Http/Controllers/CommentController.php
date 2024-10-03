<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        // Validate the incoming request
        $request->validate(['comment' => 'required']);

        // Create a new comment
        Comment::create([
            'post_id' => $postId,
            'user_id' => auth()->id(), // Get the currently authenticated user's ID
            'comment' => $request->comment,
        ]);

        // Redirect back to the post with a success message
        return back()->with('success', 'Comment added successfully!');
    }

    public function delete($id)
    {
        // Find the comment by its ID
        $comment = Comment::findOrFail($id);

        // Check if the authenticated user is the owner of the comment or the post
        if (Auth::id() !== $comment->user_id && Auth::id() !== $comment->post->user_id) {
            return redirect()->back()->with('error', 'You do not have permission to delete this comment.');
        }

        // Delete the comment
        $comment->delete();

        // Redirect back with a success message
        return back()->with('success', 'Comment deleted successfully!');
    }
}
