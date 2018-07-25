<?php


namespace Tests\Feature\Auth;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserPasswordResetTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     *@test
     */
    public function a_user_may_reset_their_password()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create(['password' => bcrypt('old_password')]);

        $response = $this->actingAs($user)->json("POST", "reset-password", [
            'current_password' => 'old_password',
            'password' => 'new_password',
            'password_confirmation' => 'new_password'
        ]);
        $response->assertStatus(200);

        $this->assertTrue(Hash::check('new_password', $user->fresh()->password));
    }

    /**
     *@test
     */
    public function the_current_password_must_match_the_logged_in_users_password()
    {
        $user = factory(User::class)->create(['password' => bcrypt('old_password')]);

        $response = $this->actingAs($user)->json("POST", "reset-password", [
            'current_password' => 'INCORRECT_password',
            'password' => 'new_password',
            'password_confirmation' => 'new_password'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('current_password');
    }

    /**
     *@test
     */
    public function the_password_is_required()
    {
        $user = factory(User::class)->create(['password' => bcrypt('old_password')]);

        $response = $this->actingAs($user)->json("POST", "reset-password", [
            'current_password' => 'old_password',
            'password' => '',
            'password_confirmation' => ''
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
    }

    /**
     *@test
     */
    public function the_password_must_be_confirmed()
    {
        $user = factory(User::class)->create(['password' => bcrypt('old_password')]);

        $response = $this->actingAs($user)->json("POST", "reset-password", [
            'current_password' => 'old_password',
            'password' => 'new_password',
            'password_confirmation' => ''
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
    }

    /**
     *@test
     */
    public function the_new_password_must_be_at_least_six_characters_long()
    {
        $user = factory(User::class)->create(['password' => bcrypt('old_password')]);

        $response = $this->actingAs($user)->json("POST", "reset-password", [
            'current_password' => 'old_password',
            'password' => 'short',
            'password_confirmation' => 'short'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
    }
}