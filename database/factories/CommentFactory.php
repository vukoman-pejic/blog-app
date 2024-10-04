<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'comment' => $this->faker->sentence,
            'post_id' => \App\Models\Post::factory(),
            'user_id' => \App\Models\User::factory(),
            'created_at' => now(),
        ];
    }
}
