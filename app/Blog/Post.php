<?php

namespace App\Blog;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;

class Post extends Model implements HasMedia
{
    use HasTranslations, HasMediaTrait;

    const TITLE_IMAGES = 'title-images';

    public $translatable = ['title', 'intro', 'description', 'body'];

    protected $fillable = ['title', 'intro', 'description', 'body'];

    public function setTitleImage($file)
    {
        return $this->addMedia($file)->preservingOriginal()->toMediaCollection(static::TITLE_IMAGES);
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
             ->performOnCollections(static::TITLE_IMAGES);
    }
}
