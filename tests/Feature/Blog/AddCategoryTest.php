<?php


namespace Tests\Feature\Blog;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AddCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function add_a_new_category_for_the_blog()
    {
        $this->withoutExceptionHandling();

        $response = $this->asLoggedInUser()->postJson("/blog/categories", [
            'title' => ['en' => 'test title', 'zh' => 'zh test title'],
            'description' => ['en' => "description", 'zh' => "zh description"],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('multilingual_categories', [
            'title' => json_encode(['en' => 'test title', 'zh' => 'zh test title']),
            'description' => json_encode(['en' => "description", 'zh' => "zh description"]),
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
        $valid = [
            'title' => ['en' => 'test title', 'zh' => 'zh test title'],
            'description' => ['en' => "description", 'zh' => "zh description"],
        ];

        $response = $this
            ->asLoggedInUser()
        ->postJson("/blog/categories", array_merge($valid, $field));


        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key ?? array_key_first($field));
    }
}
