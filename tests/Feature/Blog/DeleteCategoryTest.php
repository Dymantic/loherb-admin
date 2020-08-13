<?php


namespace Tests\Feature\Blog;


use Dymantic\MultilingualPosts\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_category()
    {
        $this->withoutExceptionHandling();

        $category = Category::create([
            'title'       => ['en' => 'test title', 'zh' => 'zh test title'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
        ]);

        $response = $this->asLoggedInUser()->deleteJson("/blog/categories/{$category->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('multilingual_categories', ['id' => $category->id]);
    }
}
