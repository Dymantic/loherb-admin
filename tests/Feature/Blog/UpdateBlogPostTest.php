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
            'intro' => ['en' => 'Old intro', 'zh' => '満版復'],
            'body' => ['en' => 'Old body', 'zh' => '永門義会可際査別件村約候証民。昌原集前全者波有索男討家王合考作染美最。催優際田度読賞督密出将育別容']
        ];

        $new_data = [
            'title' => ['en' => 'New title', 'zh' => '満版復'],
            'description' => ['en' => 'New description', 'zh' => '満版復'],
            'intro' => ['en' => 'New intro', 'zh' => '満版復'],
            'body' => ['en' => 'New body', 'zh' => '催優際田度読賞督密出将育別容']
        ];

        $post = factory(Post::class)->create($old_data);

        $response = $this->asLoggedInUser()->json("POST", "/blog/posts/{$post->id}", $new_data);
        $response->assertStatus(200);

        $this->assertDatabaseHasWithTranslations('posts', array_merge(['id' => $post->id], $new_data));
    }

    /**
     *@test
     */
    public function updating_a_blog_post_responds_with_the_updated_post_data()
    {
        $this->withoutExceptionHandling();

        $new_data = [
            'title' => ['en' => 'New title', 'zh' => '満版復'],
            'description' => ['en' => 'New description', 'zh' => '満版復'],
            'intro' => ['en' => 'New intro', 'zh' => '満版復'],
            'body' => ['en' => 'New body', 'zh' => '催優際田度読賞督密出将育別容']
        ];

        $post = factory(Post::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/blog/posts/{$post->id}", $new_data);
        $response->assertStatus(200);

        $this->assertEquals($post->fresh()->toArray(), $response->decodeResponseJson());
    }
}