@extends('base')

@section('content')
    <div class="flex justify-between items-center mt-4 mb-12">
        <h1 class="text-4xl font-sans text-grey-darkest normal">Reset Your password</h1>
        <div class="flex justify-end items-center">

        </div>
    </div>
    <div class="pt-8">
        <form action="reset-password" method="POST"
              class="max-w-sm mx-auto">
            {!! csrf_field() !!}
            <div class="my-4{{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="text-sm font-bold" for="password">Current Password</label>
                @if($errors->has('current_password'))
                    <span class="text-danger text-sm">{{ $errors->first('current_password') }}</span>
                @endif
                <input type="password" name="current_password" value="{{ old('current_password') }}" class="pl-2 border w-full block h-8 mt-2">
            </div>
            <div class="my-4{{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="text-sm font-bold" for="password">New Password</label>
                @if($errors->has('password'))
                    <span class="text-danger text-sm">{{ $errors->first('password') }}</span>
                @endif
                <input type="password" name="password" value="" class="pl-2 border w-full block h-8 mt-2">
            </div>
            <div class="my-4{{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="text-sm font-bold" for="password">Confirm New Password </label>
                @if($errors->has('password'))
                    <span class="text-danger text-sm">{{ $errors->first('password') }}</span>
                @endif
                <input type="password" name="password_confirmation" value="" class="pl-2 border w-full block h-8 mt-2">
            </div>
            <div class="">
                <button type="submit" class="w-full block my-4 bg-green text-white uppercase tracking-wide h-12">Reset Password</button>
            </div>
        </form>
    </div>
@endsection