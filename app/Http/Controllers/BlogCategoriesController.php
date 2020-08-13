<?php

namespace App\Http\Controllers;

use Dymantic\MultilingualPosts\Category;
use Illuminate\Http\Request;

class BlogCategoriesController extends Controller
{

    public function index()
    {
        return Category::get()
            ->reject(function($category) {
                $rejection_list = ['Villa', 'Cuisine', 'Patisserie', 'Estate'];
                return in_array($category->getTranslation('title', 'en'), $rejection_list);
            })->map->toArray();
    }

    public function store()
    {
        request()->validate([
            'title' => ['required'],
            'title.en' => ['required'],
            'title.zh' => ['required'],
        ]);

        Category::create(request()->all());
    }

    public function update(Category $category)
    {
        request()->validate([
            'title' => ['required'],
            'title.en' => ['required'],
            'title.zh' => ['required'],
        ]);

        $category->update(request()->only('title', 'description'));
    }

    public function delete(Category $category)
    {
        
        $category->delete();
    }
}
