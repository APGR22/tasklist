@extends('templates.admin')

@section('title')
    Admin Login
@endsection

@section('body')
    <form action="{{ route('admin.login.post') }}" method="post">
        @csrf

        <label for="username" class="form-label">Username:</label><br>
        <input type="text" name="username" id="username" class="form-text" value="{{ old('username') }}"><br>
        @error('username')
            <label for="username" class="text-danger">{{ $message }}</label><br>
        @enderror
        <br>
        <label for="password" class="form-label">Password:</label><br>
        <input type="password" name="password" id="password" class="form-text" value="{{ old('password') }}"><br>
        @error('password')
            <label for="password" class="text-danger">{{ $message }}</label><br>
        @enderror
        <br>
        @error('login-submit')
            <label for="login-submit" class="text-danger">{{ $message }}</label><br>
        @enderror
        <button type="submit" class="btn btn-primary" id="login-submit">Login</button>
    </form>
@endsection