<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{

    public function index()
    {
        return view('users.index', ['users' => User::all()->toArray()]);
    }

    public function show(User $user)
    {
        return view('users.show', ['user' => $user->toArray()]);
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        return User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password'))
        ]);

    }

    public function update(User $user)
    {
        request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update(request()->only('name', 'email'));

        return $user->fresh()->toArray();
    }

    public function delete(User $user)
    {
        $user->delete();
    }
}
