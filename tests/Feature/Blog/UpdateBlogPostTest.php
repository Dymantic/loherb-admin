<?php


namespace Tests\Feature\Blog;


use App\Blog\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateBlogPostTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_existing_blog_post_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $old_data = [
            'title' => ['en' => 'Old title', 'zh' => '満版復'],
            'description' => ['en' => 'Old description', 'zh' => '満版復'],
            'intro' => ['en' => 'Old intro', 'zh' => '満版復']
        ];

        $new_data = [
            'title' => ['en' => 'New title', 'zh' => '満版復'],
            'description' => ['en' => 'New description', 'zh' => '満版復'],
            'intro' => ['en' => 'New intro', 'zh' => '満版復']
        ];

        $post = factory(Post::class)->create($old_data);

        $response = $this->asLoggedInUser()->json("POST", "/blog/posts/{$post->id}", $new_data);
        $response->assertStatus(200);

        $this->assertDatabaseHasWithTranslations('posts', array_merge(['id' => $post->id], $new_data));
    }
}