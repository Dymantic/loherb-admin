<?php


namespace Tests\Feature\Auth;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_existing_user_can_login()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create(['email' => 'test@email.test', 'password' => bcrypt('password')]);

        $response = $this->post("/login", ['email' => 'test@email.test', 'password' => 'password']);
        $response->assertStatus(302);

        $this->assertTrue(Auth::check());
        $this->assertTrue(auth()->user()->is($user));
    }
}