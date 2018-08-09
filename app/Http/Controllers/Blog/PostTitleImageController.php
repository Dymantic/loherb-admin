<?php

namespace App\Http\Controllers\Blog;

use App\Blog\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostTitleImageController extends Controller
{
    public function store(Post $post)
    {
        request()->validate(['image' => ['required', 'image']]);
        $image = $post->setTitleImage(request('image'));

        return ['image_src' => $image->getUrl()];
    }
}
