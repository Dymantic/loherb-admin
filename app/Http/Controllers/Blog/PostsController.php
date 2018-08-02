<?php

namespace App\Http\Controllers\Blog;

use App\Blog\Post;
use App\Rules\RequiresOne;
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

    public function show(Post $post)
    {
        return $post->toArray();
    }

    public function edit(Post $post)
    {
        return view('blog.edit', ['post_id' => $post->id]);
    }

    public function store()
    {
        request()->validate([
            'title' => ['required', new RequiresOne()],
        ]);
        return Post::create([
            'title' => request('title'),
            'description' => request('description'),
            'intro' => request('intro'),
            'body' => request('body')
        ])->toArray();
    }

    public function update(Post $post)
    {
        $post->update(request()->only(['title', 'intro', 'description', 'body']));

        return $post->fresh()->toArray();
    }
}
