@extends('layouts.app')

@section('title', 'Room Details')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Room Details</h4>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ asset($room->image) }}" alt="Room Image" class="img-fluid rounded" style="max-height: 300px;">
                </div>

                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item"><strong>Title:</strong> {{ $room->title }}</li>
                    <li class="list-group-item"><strong>Description:</strong> {{ $room->description ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Price:</strong> ${{ $room->price }}</li>
                    <li class="list-group-item"><strong>WiFi:</strong> {{ $room->wifi ? 'Yes' : 'No' }}</li>
                    <li class="list-group-item"><strong>Room Type:</strong> {{ ucfirst($room->room_type) }}</li>
                    <li class="list-group-item"><strong>Status:</strong> {{ $room->status ? 'Active' : 'Inactive' }}</li>
                    <li class="list-group-item"><strong>Bed Number:</strong> {{ $room->bed_number }}</li>
                    <li class="list-group-item"><strong>Created At:</strong> {{ $room->created_at->format('Y-m-d H:i') }}</li>
                    <li class="list-group-item"><strong>Updated At:</strong> {{ $room->updated_at->format('Y-m-d H:i') }}</li>
                </ul>

                <div class="d-flex justify-content-center gap-3 mb-3">
                    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="{{ route('rooms.bookings', $room->id) }}" class="btn btn-info">
                        <i class="bi bi-calendar-check"></i> Bookings
                    </a>


                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this room?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
