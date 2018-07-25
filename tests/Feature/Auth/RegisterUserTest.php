<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_user_can_be_registered()
    {
        $this->withoutExceptionHandling();

        $user_data = [
            'name' => 'Joe Soap',
            'email' => 'test@test.test',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->asLoggedInUser()->json("POST", "/users", $user_data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => 'Joe Soap',
            'email' => 'test@test.test'
        ]);

        $user = User::where('email', 'test@test.test')->first();

        $this->assertTrue(Hash::check('password', $user->password));
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

    /**
     *@test
     */
    public function the_password_is_required()
    {
        $this->assertFieldIsInValid(['password' => '']);
    }

    /**
     *@test
     */
    public function the_password_needs_confirmation()
    {
        $response = $this->asLoggedInUser()->json("POST", "/users", [
            'name' => 'Joe Soap',
            'email' => 'test@test.test',
            'password' => 'password',
            'password_confirmation' => ''
        ]);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors('password');
    }

    /**
     *@test
     */
    public function the_password_must_be_at_least_six_characters_long()
    {
        $this->assertFieldIsInValid(['password' => 'short', 'password_confirmation' => 'short']);
    }

    private function assertFieldIsInValid($field)
    {
        $default = [
            'name' => 'Joe Soap',
            'email' => 'test@test.test',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
        $response = $this->asLoggedInUser()->json("POST", "/users", array_merge($default, $field));
        $response->assertStatus(422);

        $response->assertJsonValidationErrors(array_keys($field)[0]);
    }
}