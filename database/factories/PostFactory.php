<?php

namespace Database\Factories;
use App\Models\Post;
use Illuminate\Support\Str;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;
        $body = $this->faker->paragraph;
        $author = $this->faker->name; // Default to a randomly generated name

        return [
            'title' => $title,
            'body' => $body,
            'user_id' => User::factory(),
            'author' => $author,
            'slug' => Str::slug($title, '-'),
        ];

    }
    public function loggedInUser()
    {
        return $this->state(function (array $attributes) {
            if (auth()->check()) {
                return ['author' => auth()->user()->name];
            }
            return [];
        });
    }

}
