<?php

namespace App\Http\Controllers\Blog;

use Dymantic\MultilingualPosts\Post;
use Dymantic\MultilingualPosts\PostResource;
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

    

    public function edit(Post $post)
    {
        return view('blog.edit', ['post_id' => $post->id]);
    }
    
}
