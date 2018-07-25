@extends('base')

@section('content')
    <div class="h-screen flex justify-center items-center">
        <div class="max-w-md mx-auto p-4">
            <h1 class="mb-8 text-center">Loherb Admin</h1>
            <p class="text-xl text-center">Please login</p>
            <form action="/login" method="POST" class="max-w-sm mx-auto my-8">
                {!! csrf_field() !!}
                <div class="my-4 {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="text-sm font-bold" for="email">Email</label>
                    @if($errors->has('email'))
                        <span class="text-danger text-sm">{{ $errors->first('email') }}</span>
                    @endif
                    <input type="text" name="email" value="{{ old('email') }}" class="pl-2 border w-full block h-8 mt-2">
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="text-sm font-bold" for="password">Password: </label>
                    @if($errors->has('password'))
                        <span class="text-danger text-sm">{{ $errors->first('password') }}</span>
                    @endif
                    <input type="password" name="password" value="" class="pl-2 border w-full block h-8 mt-2">
                </div>
                <div class="my-4">
                    <label class="text-sm font-bold" for="remember-me">Remember me </label>
                    <input type="checkbox" id="remember-me">

                </div>

                <div class="form-group">
                    <button type="submit" class="w-full block my-4 bg-black text-white uppercase tracking-wide h-12">Login</button>
                </div>
                <div class="my-4 text-center">
                    <a class="text-sm text-grey" href="/admin/forgot-password">Forgot password?</a>
                </div>
            </form>
        </div>

    </div>

@endsection


