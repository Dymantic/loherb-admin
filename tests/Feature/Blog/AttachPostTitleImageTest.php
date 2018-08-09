<?php


namespace Tests\Feature\Blog;


use App\Blog\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AttachPostTitleImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_title_image_may_be_attached_to_a_post()
    {
        Storage::fake('media');
        $this->withoutExceptionHandling();

        $post = factory(Post::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/blog/posts/{$post->id}/title-image", [
            'image' => UploadedFile::fake()->image('testpic.png')
        ]);
        $response->assertStatus(200);

        $this->assertCount(1, $post->fresh()->getMedia(Post::TITLE_IMAGES));
    }

    /**
     *@test
     */
    public function the_uploaded_image_src_is_returned_in_the_response()
    {
        Storage::fake('media');
        Storage::fake('media');
        $this->withoutExceptionHandling();

        $post = factory(Post::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/blog/posts/{$post->id}/title-image", [
            'image' => UploadedFile::fake()->image('testpic.png')
        ]);
        $response->assertStatus(200);

        $image = $post->fresh()->getFirstMedia(Post::TITLE_IMAGES);

        $this->assertEquals($image->getUrl(), $response->decodeResponseJson()['image_src']);
    }

    /**
     *@test
     */
    public function the_image_is_required()
    {
        Storage::fake('media');
        $post = factory(Post::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/blog/posts/{$post->id}/title-image", [
            'image' => null
        ]);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors('image');
    }

    /**
     *@test
     */
    public function the_uploaded_file_must_be_an_image()
    {
        Storage::fake('media');
        $post = factory(Post::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/blog/posts/{$post->id}/title-image", [
            'image' => UploadedFile::fake()->create('textfile.txt')
        ]);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors('image');
    }
}