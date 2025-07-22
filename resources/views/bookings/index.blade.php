@extends('layouts.app')

@section('title', 'All Bookings')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Bookings List</h2>
            <a href="{{ route('bookings.create') }}" class="btn btn-success">Create Booking</a>
        </div>
        <table class="table table-hover bg-white shadow-sm">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Room</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Payment Status</th>
                <th>Final Price</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($bookings as $booking)
                <tr onclick="window.location='{{ route('bookings.show', $booking->id) }}';" style="cursor: pointer;">
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->user->name ?? 'N/A' }}</td>
                    <td>{{ $booking->room->title ?? 'N/A' }}</td>
                    <td>{{ $booking->start_date }}</td>
                    <td>{{ $booking->end_date }}</td>
                    <td>
                        @if($booking->status == 1)
                            <span class="badge bg-success">Room Available</span>
                        @else
                            <span class="badge bg-danger">Room Unavailable</span>
                        @endif
                    </td>

                    <td>
                        @if($booking->payment_status == 1)
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                    <td>${{ number_format($booking->final_price, 2) }}</td>
                    <td>
                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this booking?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No bookings found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection
