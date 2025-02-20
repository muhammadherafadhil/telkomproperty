@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Tasks</h1>
    @foreach($tasks as $task)
    <div class="card mb-3">
        <div class="card-body">
            <h5>{{ $task->title }}</h5>
            <p>{{ $task->description }}</p>
            <form action="{{ route('tasks.updateStatus', $task) }}" method="POST">
                @csrf
                @method('PATCH')
                <select name="status" class="form-select mb-2">
                    <option value="pending" @if($task->status == 'pending') selected @endif>Pending</option>
                    <option value="in_progress" @if($task->status == 'in_progress') selected @endif>In Progress</option>
                    <option value="completed" @if($task->status == 'completed') selected @endif>Completed</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection
