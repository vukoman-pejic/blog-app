<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    #[test]
    public function test_it_can_list_all_posts()
    {
        $user = $this->actingAsUser();

        Post::factory()->create(['user_id' => $user->id, 'title' => 'First Post']);
        Post::factory()->create(['user_id' => $user->id, 'title' => 'Second Post']);

        $response = $this->get('/posts');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
        $response->assertSee('First Post');
        $response->assertSee('Second Post');
    }

    #[test]
    public function test_it_can_show_a_post_with_comments()
    {
        $user = $this->actingAsUser();

        $post = Post::factory()->create(['user_id' => $user->id]);
        
        $post->comments()->create(['user_id' => $user->id, 'comment' => 'Great post!']);

        $response = $this->get('/posts/' . $post->id);

        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
        $response->assertSee($post->title);
        $response->assertSee('Great post!');
    }

    #[test]
    public function test_it_can_show_the_post_creation_form()
    {
        $this->actingAsUser();

        $response = $this->get('/posts/create');

        $response->assertStatus(200);
        $response->assertViewIs('posts.create');
    }

    #[test]
    public function test_it_can_store_a_new_post()
    {
        $user = $this->actingAsUser();

        $postData = [
            'title' => 'New Post',
            'content' => 'This is the content of the new post.',
        ];

        $response = $this->post('/posts', $postData);

        $response->assertRedirect('/posts');
        $response->assertSessionHas('success', 'Post created successfully.');
        $this->assertDatabaseHas('posts', [
            'title' => 'New Post',
            'content' => 'This is the content of the new post.',
            'user_id' => $user->id,
        ]);
    }

    #[test]
    public function test_it_can_show_the_post_edit_form()
    {
        $user = $this->actingAsUser();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->get('/posts/' . $post->id . '/edit');

        $response->assertStatus(200);
        $response->assertViewIs('posts.edit');
        $response->assertSee($post->title);
    }

    #[test]
    public function test_it_can_update_an_existing_post()
    {
        $user = $this->actingAsUser();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $updatedData = [
            'title' => 'Updated Post',
            'content' => 'This is the updated content.',
        ];

        $response = $this->put('/posts/' . $post->id, $updatedData);

        $response->assertRedirect('/posts');
        $response->assertSessionHas('success', 'Post updated successfully.');
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Post',
            'content' => 'This is the updated content.',
        ]);
    }

    #[test]
    public function test_it_can_delete_a_post()
    {
        $user = $this->actingAsUser();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->delete('/posts/' . $post->id);

        $response->assertRedirect('/posts');
        $response->assertSessionHas('success', 'Post deleted successfully.');
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }

    #[test]
    public function test_it_cannot_access_edit_form_of_another_users_post()
    {
        $user1 = $this->actingAsUser();
        $user2 = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user2->id]);

        $response = $this->get('/posts/' . $post->id . '/edit');

        $response->assertStatus(403);
    }

    #[test]
    public function test_it_cannot_update_another_users_post()
    {
        $user1 = $this->actingAsUser();
        $user2 = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user2->id]);

        $updatedData = [
            'title' => 'Updated Post',
            'content' => 'This is the updated content.',
        ];

        $response = $this->put('/posts/' . $post->id, $updatedData);

        $response->assertStatus(403);
    }

    #[test]
    public function test_it_cannot_delete_another_users_post()
    {
        $user1 = $this->actingAsUser();
        $user2 = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user2->id]);

        $response = $this->delete('/posts/' . $post->id);

        $response->assertStatus(403);
    }
}
