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
    use HasTranslations, PostImagesTrait;

    const TITLE_IMAGES = 'title-images';
    const BODY_IMAGES = 'body-images';

    public $translatable = ['title', 'intro', 'description', 'body'];

    protected $fillable = ['title', 'intro', 'description', 'body'];


}
