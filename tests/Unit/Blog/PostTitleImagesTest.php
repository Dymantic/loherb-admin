<?php

namespace Tests\Unit\Blog;

use App\Blog\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Models\Media;
use Tests\TestCase;

class PostTitleImagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_title_image_can_be_set_on_a_post()
    {
        Storage::fake('media');

        $post = factory(Post::class)->create();

        $image = $post->setTitleImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertInstanceOf(Media::class, $image);
        $this->assertTrue($image->model->is($post));
    }

    /**
     *@test
     */
    public function setting_a_new_title_image_will_replace_any_existing_one()
    {
        Storage::fake('media');

        $post = factory(Post::class)->create();
        $imageA = $post->setTitleImage(UploadedFile::fake()->image('testpic.png'));
        $imageB = $post->setTitleImage(UploadedFile::fake()->image('testpic_two.png'));

        $this->assertCount(1, $post->fresh()->getMedia(Post::TITLE_IMAGES));
        $this->assertTrue($post->fresh()->getFirstMedia(Post::TITLE_IMAGES)->is($imageB));
    }

    /**
     *@test
     */
    public function the_title_image_can_be_cleared()
    {
        Storage::fake('media');

        $post = factory(Post::class)->create();
        $post->setTitleImage(UploadedFile::fake()->image('testpic.png'));
        $this->assertCount(1, $post->fresh()->getMedia(Post::TITLE_IMAGES));

        $post->fresh()->clearTitleImage();

        $this->assertCount(0, $post->fresh()->getMedia(Post::TITLE_IMAGES));
    }

    /**
     *@test
     */
    public function a_post_tile_image_has_a_banner_conversion()
    {
        Storage::fake('media');

        $post = factory(Post::class)->create();
        $image = $post->setTitleImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('banner'));
    }

    /**
     *@test
     */
    public function a_post_title_image_has_a_web_conversion()
    {
        Storage::fake('media');

        $post = factory(Post::class)->create();
        $image = $post->setTitleImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));
    }
}