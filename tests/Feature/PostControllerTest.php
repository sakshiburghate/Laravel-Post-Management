<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;


class PostControllerTest extends TestCase
{
    use RefreshDatabase; 
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected function loginAdmin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
    }

    protected function loginUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function testCreatePost()
    {
        $this->loginUser();

        $response = $this->post('/posts', [
            'title' => 'Test Post',
            'body' => 'This is a test post.',
        ]);

        $response->assertStatus(302); 
        $this->assertDatabaseHas('posts', ['title' => 'Test Post']);
    }

    public function testUpdatePost()
    {
        $this->loginUser();

        $post = Post::factory()->create(['user_id' => Auth::id()]); 

        $response = $this->put("/posts/{$post->id}", [
            'title' => 'Updated Post Title',
            'body' => 'Updated post content.',
        ]);

        $response->assertStatus(302); 
        $this->assertDatabaseHas('posts', ['title' => 'Updated Post Title']);
    }

    public function testDeletePost()
    {
        $this->loginUser();

        $post = Post::factory()->create(['user_id' => Auth::id()]); 
        $response = $this->delete("/posts/{$post->id}");

        $response->assertStatus(302); 
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function testViewPosts()
    {
        $this->loginUser();

        $response = $this->get('/posts');

        $response->assertStatus(200); 
        $response->assertViewIs('posts.index'); 
     }

}
