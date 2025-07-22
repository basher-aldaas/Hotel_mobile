@extends('layouts.app')

@section('title', 'Edit Room')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Room</h2>

        <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Room Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $room->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Room Image</label>
                @if ($room->image)
                    <div class="mb-2">
                        <img src="{{ asset($room->image) }}" alt="Current Image" style="width: 120px;">
                    </div>
                @endif
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $room->description) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price ($)</label>
                <input type="number" name="price" id="price" value="{{ old('price', $room->price) }}" class="form-control @error('price') is-invalid @enderror" required>
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="wifi" class="form-label">WiFi</label>
                <select name="wifi" id="wifi" class="form-select @error('wifi') is-invalid @enderror" required>
                    <option value="1" {{ $room->wifi ? 'selected' : '' }}>Available</option>
                    <option value="0" {{ !$room->wifi ? 'selected' : '' }}>Not Available</option>
                </select>
                @error('wifi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="room_type" class="form-label">Room Type</label>
                <select name="room_type" id="room_type" class="form-select @error('room_type') is-invalid @enderror" required>
                    <option value="regular" {{ $room->room_type === 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="premium" {{ $room->room_type === 'premium' ? 'selected' : '' }}>Premium</option>
                    <option value="deluxe" {{ $room->room_type === 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                </select>
                @error('room_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="bed_number" class="form-label">Number of Beds</label>
                <input type="number" name="bed_number" id="bed_number" value="{{ old('bed_number', $room->bed_number) }}" class="form-control @error('bed_number') is-invalid @enderror" required>
                @error('bed_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" role="switch" name="status" id="status" value="1" {{ $room->status ? 'checked' : '' }}>
                <label class="form-check-label" for="status">Available</label>
            </div>

            <button type="submit" class="btn btn-primary">Update Room</button>
            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
