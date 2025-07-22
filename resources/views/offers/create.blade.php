@extends('layouts.app')

@section('title', 'Create Offer')

@section('content')
    <div class="container">
        <h2 class="mb-4">Create New Offer</h2>

        <form action="{{ route('offers.store', ['room' => old('room_id')]) }}" method="POST">
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
                <label for="title" class="form-label">Offer Title</label>
                <input type="text" name="title" id="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title') }}" required>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="3" required>{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="discount" class="form-label">Discount (%)</label>
                <input type="number" name="discount" id="discount"
                       class="form-control @error('discount') is-invalid @enderror"
                       value="{{ old('discount') }}" min="1" max="100" required>
                @error('discount')
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

            <button type="submit" class="btn btn-primary">Save Offer</button>
            <a href="{{ route('offers.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
