@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Task</h1>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Task Title</label>
            <input type="text" class="form-control" name="title" id="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Task Description</label>
            <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="assigned_to" class="form-label">Assign to (NIK)</label>
            <select class="form-select" name="assigned_to" id="assigned_to" required>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} (NIK: {{ $user->nik }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Task</button>
    </form>
</div>
@endsection
