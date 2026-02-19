@extends('templates.main')

@section('title')
    Home
@endsection

@section('header')
    @livewireStyles
@endsection

@section('body')
    {{-- <livewire:livewire.main.group.index /> --}}
    {{-- https://stackoverflow.com/questions/74413495/how-do-i-pass-data-to-a-component-in-laravel-livewire --}}
    @livewire('livewire.main.⚡index', [
        'groups' => $groups
    ])
@endsection

@section('scripts')
    @livewireScripts
@endsection