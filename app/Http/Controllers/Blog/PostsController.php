<?php

namespace App\Http\Controllers\Blog;

use App\Blog\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    public function store()
    {
        request()->validate(['title' => 'required']);
        Post::create([
            'title' => request('title'),
            'description' => request('description'),
            'intro' => request('intro'),
        ]);
    }

    public function update(Post $post)
    {
        $post->update(request()->only(['title', 'intro', 'description']));
    }
}
