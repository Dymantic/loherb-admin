<?php

namespace App\Blog;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Translatable\HasTranslations;

class Post extends Model implements HasMedia
{
    use HasTranslations, HasMediaTrait;

    const TITLE_IMAGES = 'title-images';

    public $translatable = ['title', 'intro', 'description', 'body'];

    protected $fillable = ['title', 'intro', 'description', 'body'];
}
