@extends('layouts.app')

@section('title', 'Edit Offer')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Offer</h2>

        <form action="{{ route('offers.update', $offer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="room_id" class="form-label">Room</label>
                <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ $offer->room_id == $room->id ? 'selected' : '' }}>
                            {{ $room->title }}
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
                       value="{{ old('title', $offer->title) }}"
                       class="form-control @error('title') is-invalid @enderror" required>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Optional">{{ old('description', $offer->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="discount" class="form-label">Discount (%)</label>
                <input type="number" name="discount" id="discount"
                       value="{{ old('discount', $offer->discount) }}"
                       class="form-control @error('discount') is-invalid @enderror"
                       min="0" max="100" required>
                @error('discount')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date"
                       value="{{ old('start_date', $offer->start_date) }}"
                       class="form-control @error('start_date') is-invalid @enderror" required>
                @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date"
                       value="{{ old('end_date', $offer->end_date) }}"
                       class="form-control @error('end_date') is-invalid @enderror" required>
                @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Offer</button>
            <a href="{{ route('offers.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
