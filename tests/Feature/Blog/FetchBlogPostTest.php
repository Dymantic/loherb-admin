<?php


namespace Tests\Feature\Blog;


use App\Blog\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchBlogPostTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_post_can_be_fetched_as_a_json_structure()
    {
        $this->withoutExceptionHandling();

        $post = factory(Post::class)->create();

        $response = $this->asLoggedInUser()->json("GET", "/blog/posts/{$post->id}");
        $response->assertStatus(200);

        $this->assertEquals($post->toArray(), $response->decodeResponseJson());
    }
}