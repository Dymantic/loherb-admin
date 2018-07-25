<?php


namespace Tests\Feature\Auth;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_logged_in_user_can_log_out()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post("/logout", []);
        $response->assertStatus(302);

        $this->assertFalse(Auth::check());
    }
}