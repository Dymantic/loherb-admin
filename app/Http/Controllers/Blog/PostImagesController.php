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
        $image = $post->attachImage(request('image'));

        return ['url' => config('app.url') . $image->getUrl('web')];
    }
}
