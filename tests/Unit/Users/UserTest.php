<?php

namespace Tests\Unit\Users;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_users_password_can_be_reset()
    {
        $user = factory(User::class)->create(['password' => 'old_test_pwd']);

        $user->resetPassword('new_test_pwd');

        $this->assertTrue(Hash::check('new_test_pwd', $user->fresh()->password));
    }
}