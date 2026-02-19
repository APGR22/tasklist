@extends('templates.main')

@section('title')
    {{ $group->name }}
@endsection

@section('body')
    <a href="{{ url('/') }}">
        <button class="btn btn-secondary">Back</button>
    </a>
    <table class="table table-light">
        <tr>
            <th>Tasks</th>
            <th>Vote</th>
            <th>Chat</th>
        </tr>
        @foreach ($tasks as $task_id)
            @php
                $task = \App\Models\Task::find($task_id);
                $voted = in_array($task_id, $tasks_voted) ? 'Yes' : 'No';
            @endphp

            <tr>
                <td>{{ $task->name }}</td>
                <td>{{ $voted }}</td>
                <td>
                    <a href="{{ url(url()->current().'/'.$task->uuid) }}">
                        <button class="btn btn-primary">Chat</button>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection