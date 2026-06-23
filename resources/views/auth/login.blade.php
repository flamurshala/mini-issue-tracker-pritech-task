@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <h1>Login</h1>

    <form action="{{ route('login.store') }}" method="POST" style="display: grid; gap: 16px; max-width: 520px;">
        @csrf

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
        </div>

        <label style="display: flex; align-items: center; gap: 8px;">
            <input type="checkbox" name="remember" value="1">
            Remember me
        </label>

        <div style="display: flex; align-items: center; gap: 12px;">
            <button type="submit" style="background: #2563eb; border: 0; border-radius: 6px; color: #ffffff; cursor: pointer; padding: 10px 14px;">Login</button>
            <a href="{{ route('register') }}">Create an account</a>
        </div>
    </form>
@endsection
