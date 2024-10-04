<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    #[test]
    public function test_it_can_create_a_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $commentData = [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => 'This is a test comment.',
        ];

        $comment = Comment::create($commentData);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => 'This is a test comment.',
        ]);
    }

    #[test]
    public function test_it_can_update_a_comment()
    {
        $comment = Comment::factory()->create();

        $updatedData = [
            'comment' => 'Updated comment text.',
        ];

        $comment->update($updatedData);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'comment' => 'Updated comment text.',
        ]);
    }

    #[test]
    public function test_it_can_delete_a_comment()
    {
        $comment = Comment::factory()->create();

        $comment->delete();

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    #[test]
    public function test_it_belongs_to_a_post()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);

        $this->assertInstanceOf(Post::class, $comment->post);
        $this->assertEquals($post->id, $comment->post->id);
    }

    #[test]
    public function test_it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $comment->user);
        $this->assertEquals($user->id, $comment->user->id);
    }
}
