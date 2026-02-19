@extends('templates.root')

@section('root.title')
    @yield('title')
@endsection

@section('root.header')
    @yield('header')
@endsection

@section('root.body')
    @if(isset($system_message))
        <div class="container-fluid border-1 border-black bg-dark">
            <h2 class="text-light">
                {{ $system_message }}
            </h2>
        </div>
    @endif

    <nav class="navbar">
        <button class="btn btn-primary">Logout</button>
    </nav>

    @yield('body')
@endsection

@section('root.scripts')
    @yield('scripts')
@endsection