<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{

    use AuthorizesRequests;

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
        return redirect()->route('posts.show', $postId)->with('success', 'Comment added successfully.');
    }

    public function delete($id)
    {
        // Find the comment by its ID
        $comment = Comment::findOrFail($id);

        // Check if the authenticated user is the owner of the comment
        $this->authorize('delete', $comment);

        // Delete the comment
        $comment->delete();

        // Redirect back with a success message
        return back()->with('success', 'Comment deleted successfully!');
    }
}
