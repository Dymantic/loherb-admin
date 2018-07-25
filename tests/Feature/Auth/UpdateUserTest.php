<?php


namespace Tests\Feature\Auth;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_user_may_be_updated()
    {
        $this->withoutExceptionHandling();

        $old_data = ['name' => 'Old name', 'email' => 'old@email.test'];
        $new_data = ['name' => 'New name', 'email' => 'new@email.test'];

        $user = factory(User::class)->create($old_data);

        $response = $this->asLoggedInUser()->json("POST", "/users/{$user->id}", $new_data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', array_merge(['id' => $user->id], $new_data));
    }

    /**
     *@test
     */
    public function updating_a_user_responds_with_fresh_user_data()
    {
        $this->withoutExceptionHandling();

        $old_data = ['name' => 'Old name', 'email' => 'old@email.test'];
        $new_data = ['name' => 'New name', 'email' => 'new@email.test'];

        $user = factory(User::class)->create($old_data);

        $response = $this->asLoggedInUser()->json("POST", "/users/{$user->id}", $new_data);
        $response->assertStatus(200);

        $this->assertEquals($user->fresh()->toArray(), $response->decodeResponseJson());
    }

    /**
     *@test
     */
    public function the_name_may_change_and_the_email_remains_the_same()
    {
        $this->withoutExceptionHandling();

        $old_data = ['name' => 'Old name', 'email' => 'old@email.test'];
        $new_data = ['name' => 'New name', 'email' => 'old@email.test'];

        $user = factory(User::class)->create($old_data);

        $response = $this->asLoggedInUser()->json("POST", "/users/{$user->id}", $new_data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', array_merge(['id' => $user->id], $new_data));
    }

    /**
     *@test
     */
    public function the_name_is_required()
    {
        $this->assertFieldIsInValid(['name' => '']);
    }

    /**
     *@test
     */
    public function the_email_field_is_required()
    {
        $this->assertFieldIsInValid(['email' => '']);
    }

    /**
     *@test
     */
    public function the_email_must_be_a_valid_format()
    {
        $this->assertFieldIsInValid(['email' => 'not-a-valid-email-address']);
    }

    /**
     *@test
     */
    public function the_email_address_must_be_unique()
    {
        factory(User::class)->create(['email' => 'used@address.test']);
        $this->assertFieldIsInValid(['email' => 'used@address.test']);
    }

    private function assertFieldIsInvalid($field)
    {
        $default = ['name' => 'Old name', 'email' => 'old@email.test'];
        $user = factory(User::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/users/{$user->id}", array_merge($default, $field));
        $response->assertStatus(422);

        $response->assertJsonValidationErrors(array_keys($field)[0]);
    }
}