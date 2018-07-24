<?php

namespace App\Blog;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'intro', 'description'];
    
    protected $fillable = ['title', 'intro', 'description'];
}
