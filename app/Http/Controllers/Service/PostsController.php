<?php

namespace App\Http\Controllers\Service;

use App\Blog\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(15);

        return [
            'posts' => $posts->items(),
            'page' => $posts->currentPage(),
            'total_pages' => $posts->lastPage()
        ];
    }
}
