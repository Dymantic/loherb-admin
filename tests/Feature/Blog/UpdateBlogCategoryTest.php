<?php


namespace Tests\Feature\Blog;


use Dymantic\MultilingualPosts\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateBlogCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_blog_category()
    {
        $this->withoutExceptionHandling();

        $category = Category::create([
            'title'       => ['en' => 'test title', 'zh' => 'zh test title'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
        ]);

        $response = $this->asLoggedInUser()->postJson("/blog/categories/{$category->id}", [
            'title'       => ['en' => 'new title', 'zh' => 'zh new title'],
            'description' => ['en' => 'new description', 'zh' => 'zh new description'],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('multilingual_categories', [
            'title'       => json_encode(['en' => 'new title', 'zh' => 'zh new title']),
            'description' => json_encode(['en' => "new description", 'zh' => "zh new description"]),
        ]);
    }

    /**
     *@test
     */
    public function the_title_is_required()
    {
        $this->assertFieldIsInvalid(['title' => null]);
    }

    /**
     *@test
     */
    public function the_title_is_required_in_both_languages()
    {
        $this->assertFieldIsInvalid(['title' => ['en' => null, 'zh' => 'zh test title']], 'title.en');
        $this->assertFieldIsInvalid(['title' => ['en' => 'test title', 'zh' => '']], 'title.zh');
    }


    private function assertFieldIsInvalid($field, $error_key = null)
    {
        $category = Category::create([
            'title'       => ['en' => 'test title', 'zh' => 'zh test title'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
        ]);

        $valid = [
            'title'       => ['en' => 'new title', 'zh' => 'zh new title'],
            'description' => ['en' => 'new description', 'zh' => 'zh new description'],
        ];

        $response = $this
            ->asLoggedInUser()
            ->postJson("/blog/categories/{$category->id}", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key ?? array_key_first($field));
    }
}
