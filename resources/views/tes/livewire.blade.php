@extends('templates.main')

@section('header')
    @livewireStyles
@endsection

@section('body')
    {{  $_SERVER['REMOTE_ADDR'] }}
    <h1 class="h1">Livewire</h1>
    <livewire:livewire.test.testlivewire />
@endsection

@section('scripts')
    @livewireScripts
@endsection