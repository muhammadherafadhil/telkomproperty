@extends('welcome')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Penyusunan Rencana</h2>
    <a href="{{ route('plans.create') }}" class="btn btn-primary mb-3">Buat Rencana Baru</a>

    <div class="list-group">
        @foreach($plans as $plan)
        <a href="{{ route('plans.show', $plan->id) }}" class="list-group-item list-group-item-action">
            <h5>{{ $plan->judul }}</h5>
            <p>{{ Str::limit($plan->deskripsi, 100) }}</p>
            <p>Status: <strong>{{ ucfirst($plan->status) }}</strong></p>
        </a>
        @endforeach
    </div>
</div>
@endsection
