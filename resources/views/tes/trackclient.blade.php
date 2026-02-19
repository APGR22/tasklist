@extends('templates.main')

@section('header')
    @livewireStyles
@endsection

@section('body')
    {{  $_SERVER['REMOTE_ADDR'] }}
@endsection

@section('scripts')
    @livewireScripts
@endsection