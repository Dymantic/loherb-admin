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
}