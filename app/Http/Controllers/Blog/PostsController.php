<?php

namespace App\Http\Controllers\Blog;

use App\Blog\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{

    public function index()
    {
        $posts = Post::latest()->paginate(15);
        return view('blog.index', [
            'posts' => $posts->items(),
            'page' => $posts->currentPage(),
            'total_pages' => $posts->lastPage()
        ]);
    }

    public function store()
    {
        request()->validate([
            'title' => 'required',
            'title.*' => 'required'
        ]);
        return Post::create([
            'title' => request('title'),
            'description' => request('description'),
            'intro' => request('intro'),
        ])->toArray();
    }

    public function update(Post $post)
    {
        $post->update(request()->only(['title', 'intro', 'description']));
    }
}
