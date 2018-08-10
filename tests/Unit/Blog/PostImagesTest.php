<?php


namespace Tests\Unit\Blog;


use App\Blog\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Models\Media;
use Tests\TestCase;

class PostImagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_image_may_be_attached_to_a_post()
    {
        Storage::fake('media');
        $post = factory(Post::class)->create();

        $image = $post->attachImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertInstanceOf(Media::class, $image);
        $this->assertTrue($post->fresh()->getFirstMedia(Post::BODY_IMAGES)->is($image));
    }

    /**
     *@test
     */
    public function an_post_image_has_a_web_conversion()
    {
        Storage::fake('media');

        $post = factory(Post::class)->create();
        $image = $post->attachImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));
    }
}