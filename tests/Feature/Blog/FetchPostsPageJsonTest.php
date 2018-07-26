<?php


namespace Tests\Feature\Blog;


use App\Blog\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchPostsPageJsonTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_page_of_fifteen_posts_can_be_fetched()
    {
        $this->withoutExceptionHandling();
        $posts = factory(Post::class, 20)->create();

        $response = $this->asLoggedInUser()->json("GET", "/api/blog/posts");
        $response->assertStatus(200);

        $expected = [
            'posts' => Post::latest()->limit(15)->get()->toArray(),
            'page' => 1,
            'total_pages' => 2
        ];

        $this->assertEquals($expected, $response->decodeResponseJson());
    }
}