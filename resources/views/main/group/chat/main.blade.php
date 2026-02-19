@extends('templates.main')

@section('title')
    @php
        $task = \App\Models\Task::where('uuid', '=', $uuid_task)->first();
    @endphp
    {{ $task->name }}
@endsection

@section('body')
    @livewire('livewire.main.chat.⚡index', [
        'uuid_group' => $uuid_group,
        'uuid_task' => $uuid_task
    ])
@endsection