<?php

namespace App\Http\Controllers\Blog;

use App\Blog\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    public function store()
    {
        Post::create([
            'title' => request('title'),
            'description' => request('description'),
            'intro' => request('intro'),
        ]);
    }
}
