<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[test]
    public function test_it_can_create_a_user()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
        ];

        $user = User::create($userData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    #[test]
    public function test_it_can_update_a_user()
    {
        $user = User::factory()->create();

        $updatedData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ];

        $user->update($updatedData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
    }

    #[test]
    public function test_it_can_delete_a_user()
    {
        $user = User::factory()->create();

        $user->delete();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    #[test]
    public function test_it_has_many_posts()
    {
        $user = User::factory()->create();

        $post1 = Post::factory()->create(['user_id' => $user->id]);
        $post2 = Post::factory()->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->posts);
        $this->assertTrue($user->posts->contains($post1));
        $this->assertTrue($user->posts->contains($post2));
    }

    #[test]
    public function test_it_has_many_comments()
    {
        $user = User::factory()->create();

        $comment1 = Comment::factory()->create(['user_id' => $user->id]);
        $comment2 = Comment::factory()->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->comments);
        $this->assertTrue($user->comments->contains($comment1));
        $this->assertTrue($user->comments->contains($comment2));
    }
}
