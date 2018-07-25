<?php

namespace App\Http\Controllers;

use App\Rules\MatchesCurrentPassword;
use Illuminate\Http\Request;

class UserPasswordController extends Controller
{
    public function update()
    {
        request()->validate([
            'current_password' => [new MatchesCurrentPassword],
            'password' => ['required', 'confirmed', 'min:6']
        ]);
        auth()->user()->resetPassword(request('password'));

        return redirect("/");
    }
}
