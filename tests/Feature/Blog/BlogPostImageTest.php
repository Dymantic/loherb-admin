<?php


namespace Tests\Feature\Blog;


use App\Blog\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogPostImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_image_can_be_added_to_a_post()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media');

        $post = factory(Post::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/blog/posts/{$post->id}/images", [
            'image' => UploadedFile::fake()->image('testpic.png')
        ]);
        $response->assertStatus(200);

        $this->assertCount(1, $post->fresh()->getMedia(Post::BODY_IMAGES));
    }

    /**
     *@test
     */
    public function the_image_is_required()
    {
        Storage::fake('media');

        $post = factory(Post::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/blog/posts/{$post->id}/images", [
            'image' => null
        ]);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors('image');
    }

    /**
     *@test
     */
    public function the_image_must_be_a_valid_image_file()
    {
        Storage::fake('media');

        $post = factory(Post::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/blog/posts/{$post->id}/images", [
            'image' => UploadedFile::fake()->create('totally-not-an-image.txt')
        ]);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors('image');
    }
}