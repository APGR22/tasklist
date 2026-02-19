@extends('templates.admin')

@section('body')
    <h1>Admin</h1>
    @livewire('livewire.main.admin.⚡main', 
    compact('users', 'admins')
    )
@endsection