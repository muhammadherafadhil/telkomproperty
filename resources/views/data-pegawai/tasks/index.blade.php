@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Tasks</h1>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Assigned To</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->assignee->name ?? 'Unassigned' }}</td>
                <td>{{ $task->status }}</td>
                <td><a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-info">Details</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
