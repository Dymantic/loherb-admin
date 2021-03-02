<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dymantic\MultilingualPosts\Post;
use Illuminate\Http\Request;

class BlogPostsController extends Controller
{
    public function index()
    {
        $page = request('page', 1);

        $posts = Post::latest('updated_at')->paginate(15);

        return [
            'data' => $posts->items(),
            'meta' => ['current_page' => $page],
        ];
    }
}
