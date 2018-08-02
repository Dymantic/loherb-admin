<?php

namespace Tests\Feature\Blog;

use App\Blog\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_guest_may_not_create_a_post()
    {
        $response = $this->asGuest()->json("POST", "/blog/posts", ["title" => ["en" => "hello"]]);
        $response->assertStatus(401);

        $this->assertCount(0, Post::all());
    }

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

        $response = $this->asLoggedInUser()->json("POST", "blog/posts", $post_data);
        $response->assertStatus(200);

        $this->assertDatabaseHasWithTranslations('posts', [
            'title' => ['en' => 'Test Title'],
            'description' => ['en' => 'Test Description'],
            'intro' => ['en' => 'Test Intro']
        ]);
    }

    /**
     *@test
     */
    public function a_post_may_be_created_with_more_than_one_language()
    {
        $this->withoutExceptionHandling();
        $post_data = [
            'title' => ['en' => 'Test Title', 'zh' => '満版復'],
            'description' => ['en' => 'Test Description', 'zh' => '永門義会可際査別件村約候証民'],
            'intro' => ['en' => 'Test Intro', 'zh' => '永門義会可際査別件村約候証民'],
            'body' => ['en' => 'Test body', '永門義会可際査別件村約候証民。昌原集前全者波有索男討家王合考作染美最。催優際田度読賞督密出将育別容']
        ];

        $response = $this->asLoggedInUser()->json("POST", "blog/posts", $post_data);
        $response->assertStatus(200);

        $this->assertDatabaseHasWithTranslations('posts', [
            'title' => ['en' => 'Test Title', 'zh' => '満版復'],
            'description' => ['en' => 'Test Description', 'zh' => '永門義会可際査別件村約候証民'],
            'intro' => ['en' => 'Test Intro', 'zh' => '永門義会可際査別件村約候証民'],
            'body' => ['en' => 'Test body', '永門義会可際査別件村約候証民。昌原集前全者波有索男討家王合考作染美最。催優際田度読賞督密出将育別容']
        ]);
    }

    /**
     *@test
     */
    public function creating_a_post_responds_with_post_data()
    {
        $this->withoutExceptionHandling();
        $post_data = [
            'title' => ['en' => 'Test Title'],
            'description' => ['en' => 'Test Description'],
            'intro' => ['en' => 'Test Intro']
        ];

        $response = $this->asLoggedInUser()->json("POST", "blog/posts", $post_data);
        $response->assertStatus(200);

        $this->assertCount(1, Post::all());
        $post = Post::first();

        $this->assertEquals($post->toArray(), $response->decodeResponseJson());
    }

    /**
     *@test
     */
    public function a_blog_post_may_be_created_with_only_a_title()
    {
        $this->withoutExceptionHandling();
        $post_data = [
            'title' => ['zh' => '満版復'],
        ];

        $response = $this->asLoggedInUser()->json("POST", "blog/posts", $post_data);
        $response->assertStatus(200);

        $this->assertDatabaseHasWithTranslations('posts', [
            'title' => ['zh' => '満版復'],
        ]);
    }

    /**
     *@test
     */
    public function the_title_must_be_present_in_at_least_a_single_language()
    {
        $response = $this->asLoggedInUser()->json("POST", "blog/posts", []);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors('title');
    }

    /**
     *@test
     */
    public function the_title_cannot_be_empty()
    {
        $response = $this->asLoggedInUser()->json("POST", "blog/posts", [
            'title' => ['en' => '']
        ]);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors('title');
    }

    /**
     *@test
     */
    public function a_post_only_needs_one_title_lang_to_valid()
    {
        $this->withoutExceptionHandling();
        $response = $this->asLoggedInUser()->json("POST", "blog/posts", [
            'title' => ['en' => 'test title', 'zh' => '']
        ]);
        $response->assertStatus(200);
    }
}