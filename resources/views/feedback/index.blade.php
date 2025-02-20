@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Feedback Anda</h3>
    @foreach ($feedbacks as $feedback)
        <div class="card mb-3">
            <div class="card-body">
                <p>{{ $feedback->content }}</p>
                <small>Status: {{ ucfirst($feedback->status) }}</small>
            </div>
        </div>
    @endforeach

    <form action="{{ route('feedback.store') }}" method="POST">
        @csrf
        <textarea name="content" class="form-control" placeholder="Tulis feedback..." required></textarea>
        <button type="submit" class="btn btn-primary mt-2">Kirim Feedback</button>
    </form>
</div>
@endsection
