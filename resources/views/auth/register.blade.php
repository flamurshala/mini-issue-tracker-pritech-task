@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <h1>Register</h1>

    <form action="{{ route('register.store') }}" method="POST" style="display: grid; gap: 16px; max-width: 520px;">
        @csrf

        <div>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
        </div>

        <div style="display: flex; align-items: center; gap: 12px;">
            <button type="submit" style="background: #2563eb; border: 0; border-radius: 6px; color: #ffffff; cursor: pointer; padding: 10px 14px;">Register</button>
            <a href="{{ route('login') }}">Already have an account?</a>
        </div>
    </form>
@endsection
