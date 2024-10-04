<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    #[test]
    public function test_it_can_create_a_post()
    {
        $user = User::factory()->create();
        $postData = [
            'title' => 'Test Title',
            'content' => 'Test Content',
        ];

        $response = $this->actingAs($user)->post('/posts', $postData);

        $this->assertDatabaseHas('posts', $postData);
    }

    #[test]
    public function test_it_requires_a_title()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/posts', [
            'content' => 'Content without a title.',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    #[test]
    public function test_it_requires_content()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/posts', [
            'title' => 'Title without content',
        ]);

        $response->assertSessionHasErrors(['content']);
    }

    #[test]
    public function test_it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'Title',
            'content' => 'This is a post content.',
        ]);

        $this->assertInstanceOf(User::class, $post->user);
        $this->assertEquals($user->id, $post->user->id);
    }

    #[test]
    public function test_it_can_update_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $updatedData = [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
        ];

        $response = $this->actingAs($user)->put("/posts/{$post->id}", $updatedData);

        $this->assertDatabaseHas('posts', array_merge(['id' => $post->id], $updatedData));
    }

    #[test]
    public function test_it_can_delete_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $postId = $post->id;

        $response = $this->actingAs($user)->delete("/posts/{$postId}");

        $this->assertDatabaseMissing('posts', ['id' => $postId]);
    }

    #[test]
    public function test_it_has_timestamps()
    {
        $user = User::factory()->create();
        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'Title',
            'content' => 'This is a post content.',
        ]);

        $this->assertNotNull($post->created_at);
        $this->assertNotNull($post->updated_at);
    }

    #[test]
    public function test_it_can_be_created_with_factory()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'Factory Post Title',
            'content' => 'Factory post content.',
        ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Factory Post Title',
            'content' => 'Factory post content.',
        ]);
    }

    #[test]
    public function test_it_can_get_comments()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $post->comments()->create([
            'user_id' => $user->id,
            'comment' => 'This is a comment on the post.',
        ]);

        $this->assertCount(1, $post->comments);
    }
}
