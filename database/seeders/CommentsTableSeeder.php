<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            // Randomly assign 3 users to comment on each post
            foreach ($users->random(3) as $user) {
                Comment::factory()->create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}