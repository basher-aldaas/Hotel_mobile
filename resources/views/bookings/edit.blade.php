@extends('layouts.app')

@section('title', 'Edit Booking')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Booking</h2>

        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="user_id" class="form-label">User</label>
                <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                    @foreach($booking as $bo)
                        <option value="{{ $booking->id }}" {{ $booking->user_id == $booking->id ? 'selected' : '' }}>
                            {{ $booking->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="room_id" class="form-label">Room</label>
                <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ $booking->room_id == $room->id ? 'selected' : '' }}>
                            {{ $room->title }}
                        </option>
                    @endforeach
                </select>
                @error('room_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date"
                       value="{{ old('start_date', $booking->start_date) }}"
                       class="form-control @error('start_date') is-invalid @enderror" required>
                @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date"
                       value="{{ old('end_date', $booking->end_date) }}"
                       class="form-control @error('end_date') is-invalid @enderror" required>
                @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="guests_count" class="form-label">Guests Count</label>
                <input type="number" name="guests_count" id="guests_count"
                       value="{{ old('guests_count', $booking->guests_count) }}"
                       class="form-control @error('guests_count') is-invalid @enderror" min="1" required>
                @error('guests_count')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="payment_status" class="form-label">Payment Status</label>
                <select name="payment_status" id="payment_status"
                        class="form-select @error('payment_status') is-invalid @enderror" required>
                    <option value="0" {{ $booking->payment_status == 0 ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ $booking->payment_status == 1 ? 'selected' : '' }}>Paid</option>
                </select>
                @error('payment_status')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="final_price" class="form-label">Final Price</label>
                <input type="number" step="0.01" name="final_price" id="final_price"
                       value="{{ old('final_price', $booking->final_price) }}"
                       class="form-control @error('final_price') is-invalid @enderror" min="0" required>
                @error('final_price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Booking</button>
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
