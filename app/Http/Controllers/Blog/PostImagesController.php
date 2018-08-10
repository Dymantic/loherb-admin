<?php

namespace App\Http\Controllers\Blog;

use App\Blog\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostImagesController extends Controller
{
    public function store(Post $post)
    {
        request()->validate(['image' => ['required', 'image']]);
        $post->attachImage(request('image'));
    }
}
