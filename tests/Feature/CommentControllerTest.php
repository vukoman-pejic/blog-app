<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    #[test]
    public function test_it_can_store_a_comment()
    {
        $user = $this->actingAsUser();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $commentData = [
            'comment' => 'This is a test comment.',
        ];

        $response = $this->post(route('comments.store', $post->id), $commentData);

        $response->assertRedirect(route('posts.show', $post->id));
        $response->assertSessionHas('success', 'Comment added successfully.');
        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => 'This is a test comment.',
        ]);
    }

    #[test]
    public function test_it_cannot_store_a_comment_without_content()
    {
        $user = $this->actingAsUser();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->post(route('comments.store', $post->id), ['comment' => '']);

        $response->assertSessionHasErrors(['comment']);
    }

    #[test]
    public function test_it_can_delete_a_comment()
    {
        $user = $this->actingAsUser();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $user->id]);

        $response = $this->delete(route('comments.delete', $comment->id));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Comment deleted successfully!');
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    #[test]
    public function test_it_cannot_delete_a_comment_that_does_not_belong_to_user()
    {
        $user1 = $this->actingAsUser();
        $user2 = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user2->id]);
        $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $user2->id]);

        $this->actingAs($user1);
        $response = $this->delete(route('comments.delete', $comment->id));

        $response->assertStatus(403);
    }
}
