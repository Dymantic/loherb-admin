<?php

namespace Tests\Feature\Blog;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_blog_post_can_be_created()
    {
        $this->withoutExceptionHandling();
        $post_data = [
          'title' => ['en' => 'Test Title'],
          'description' => ['en' => 'Test Description'],
          'intro' => ['en' => 'Test Intro']
        ];

        $response = $this->json("POST", "blog/posts", $post_data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('posts', ['title' => json_encode(['en' => 'Test Title'])]);
    }
}