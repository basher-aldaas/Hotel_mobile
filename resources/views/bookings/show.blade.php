@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Booking Details</h4>
            </div>
            <div class="card-body">

                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item">
                        <strong>User:</strong> {{ $booking->user->name ?? 'N/A' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Room:</strong> {{ $booking->room->title ?? 'N/A' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Start Date:</strong> {{ $booking->start_date }}
                    </li>
                    <li class="list-group-item">
                        <strong>End Date:</strong> {{ $booking->end_date }}
                    </li>
                    <li class="list-group-item">
                        <strong>Guests Count:</strong> {{ $booking->guests_count }}
                    </li>
                    <li class="list-group-item">
                        <strong>Payment Status:</strong>
                        @if($booking->payment_status == 1)
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </li>
                    <li class="list-group-item">
                        <strong>Final Price:</strong> ${{ number_format($booking->final_price, 2) }}
                    </li>
                    <li class="list-group-item">
                        <strong>Created At:</strong> {{ $booking->created_at->format('Y-m-d H:i') }}
                    </li>
                    <li class="list-group-item">
                        <strong>Updated At:</strong> {{ $booking->updated_at->format('Y-m-d H:i') }}
                    </li>
                </ul>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>

                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this booking?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                        ← Back to Bookings
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
