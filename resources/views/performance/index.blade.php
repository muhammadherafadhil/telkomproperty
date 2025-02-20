@extends('welcome')

@section('title', 'Daftar Kinerja')

@section('content')
<div class="container py-5">
    <h3 class="mb-4 text-center">Daftar Kinerja Anda</h3>

    <!-- Card Container -->
    <div class="row">
        @foreach($performances as $performance)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-light rounded">
                    <div class="card-body">
                        <h5 class="card-title">{{ $performance->user->name }} 
                            <small class="text-muted">(NIK: {{ $performance->user->nik }})</small>
                        </h5>
                        <p class="card-text">
                            <strong>Judul:</strong> {{ $performance->title }}
                        </p>
                        <p class="card-text">
                            <strong>Deskripsi:</strong> {{ Str::limit($performance->description, 100) }} 
                            @if(strlen($performance->description) > 100) 
                                <a href="#" class="text-decoration-none text-primary" data-bs-toggle="modal" data-bs-target="#descriptionModal{{ $performance->id }}">Read More</a>
                            @endif
                        </p>
                        <p class="card-text">
                            <strong>Rating:</strong> {{ $performance->rating }} 
                        </p>
                        <p class="card-text">
                            <strong>Skor:</strong> {{ $performance->score }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Modal for full description -->
            <div class="modal fade" id="descriptionModal{{ $performance->id }}" tabindex="-1" aria-labelledby="descriptionModalLabel{{ $performance->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="descriptionModalLabel{{ $performance->id }}">Deskripsi Lengkap</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>{{ $performance->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('styles')
<!-- Add custom styles if needed -->
<style>
    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .card-text {
        font-size: 1rem;
    }

    .text-primary {
        font-weight: bold;
    }

    .card {
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: scale(1.02);
    }

    .modal-content {
        border-radius: 10px;
    }
</style>
@endpush

@push('scripts')
<!-- Include Bootstrap JS if necessary for modal functionality -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endpush
