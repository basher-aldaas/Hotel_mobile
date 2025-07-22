@extends('layouts.app')

@section('title', 'Create Booking')

@section('content')
    <div class="container">
        <h2 class="mb-4">Create New Booking</h2>

        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="room_id" class="form-label">Room</label>
                <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                    <option value="" disabled selected>Select a room</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                            {{ $room->title }} - ${{ $room->price }}
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
                       class="form-control @error('start_date') is-invalid @enderror"
                       value="{{ old('start_date') }}" required>
                @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date"
                       class="form-control @error('end_date') is-invalid @enderror"
                       value="{{ old('end_date') }}" required>
                @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="guests_count" class="form-label">Number of Guests</label>
                <input type="number" name="guests_count" id="guests_count"
                       class="form-control @error('guests_count') is-invalid @enderror"
                       value="{{ old('guests_count', 1) }}" min="1" required>
                @error('guests_count')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="payment_status" class="form-label">Payment Status</label>
                <select name="payment_status" id="payment_status"
                        class="form-select @error('payment_status') is-invalid @enderror" required>
                    <option value="1" {{ old('payment_status') == '1' ? 'selected' : '' }}>Pay Now</option>
                    <option value="0" {{ old('payment_status') == '0' ? 'selected' : '' }}>Pay Later</option>
                </select>
                @error('payment_status')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save Booking</button>
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
