@extends('layouts.app')

@section('title', 'Bookings for Room: ' . $room->title)

@section('content')
    <div class="container">
        <h2 class="mb-4">Bookings for Room: <strong>{{ $room->title }}</strong></h2>

        <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-secondary mb-3">
            ← Back to Room Details
        </a>

        @if($room->bookings->count() > 0)
            <table class="table table-hover bg-white shadow-sm">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Final Price</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($room->bookings as $booking)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $booking->user->name ?? 'N/A' }}</td>
                        <td>{{ $booking->start_date }}</td>
                        <td>{{ $booking->end_date }}</td>
                        <td>
                            @if($booking->status == 0)
                                <span class="badge bg-danger">Room Unavailable</span>
                            @else
                                <span class="badge bg-success text-dark">Unavailable</span>
                            @endif
                        </td>                        <td>
                            @if($booking->payment_status == 1)
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>${{ number_format($booking->final_price, 2) }}</td>
                        <td>
                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-primary">View</a>
                            <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">
                No bookings found for this room.
            </div>
        @endif
    </div>
@endsection
