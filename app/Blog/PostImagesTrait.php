<?php


namespace App\Blog;


use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

trait PostImagesTrait
{
    use HasMediaTrait;

    public function setTitleImage($file)
    {
        $this->clearTitleImage();
        return $this->addMedia($file)->preservingOriginal()->toMediaCollection(static::TITLE_IMAGES);
    }

    public function clearTitleImage()
    {
        $this->clearMediaCollection(static::TITLE_IMAGES);
    }

    public function attachImage($image)
    {
        return $this->addMedia($image)->preservingOriginal()->toMediaCollection(static::BODY_IMAGES);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('banner')
             ->fit(Manipulations::FIT_MAX, 2000, 1000)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections(static::TITLE_IMAGES);

        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_MAX, 1200, 800)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections(static::TITLE_IMAGES, static::BODY_IMAGES);
    }
}