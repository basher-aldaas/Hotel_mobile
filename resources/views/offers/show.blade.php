@extends('layouts.app')

@section('title', 'Offer Details')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Offer Details</h4>
            </div>
            <div class="card-body">

                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item">
                        <strong>Room:</strong> {{ $offer->room->title ?? 'N/A' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Title:</strong> {{ $offer->title }}
                    </li>
                    <li class="list-group-item">
                        <strong>Description:</strong> {{ $offer->description ?? 'No description' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Discount:</strong> {{ $offer->discount }}%
                    </li>
                    <li class="list-group-item">
                        <strong>Start Date:</strong> {{ \Carbon\Carbon::parse($offer->start_date)->format('Y-m-d') }}
                    </li>
                    <li class="list-group-item">
                        <strong>End Date:</strong> {{ \Carbon\Carbon::parse($offer->end_date)->format('Y-m-d') }}
                    </li>
                    <li class="list-group-item">
                        <strong>Created At:</strong> {{ $offer->created_at->format('Y-m-d H:i') }}
                    </li>
                    <li class="list-group-item">
                        <strong>Updated At:</strong> {{ $offer->updated_at->format('Y-m-d H:i') }}
                    </li>
                </ul>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('offers.edit', $offer->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>

                    <form action="{{ route('offers.destroy', $offer->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this offer?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('offers.index') }}" class="btn btn-secondary">
                        ← Back to Offers
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
