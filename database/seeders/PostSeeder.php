<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;


class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           $users = User::all();

        foreach ($users as $user) {
            Post::factory()->count(5)->loggedInUser()->create([
                'user_id' => $user->id,
                'author' => $user->name,
                'slug' => function (array $attributes) {
                    return Str::slug($attributes['title'], '-');
                },

            ]);
        }

    }
}
