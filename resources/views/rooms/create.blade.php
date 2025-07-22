@extends('layouts.app')

@section('title', 'Create Room')

@section('content')
    <div class="container">
        <h2 class="mb-4">Create New Room</h2>

        <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Room Title</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Room Image</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" required>
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3"></textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price ($)</label>
                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" required>
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="wifi" class="form-label">WiFi</label>
                <select name="wifi" id="wifi" class="form-select @error('wifi') is-invalid @enderror" required>
                    <option value="1">Available</option>
                    <option value="0">Not Available</option>
                </select>
                @error('wifi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="room_type" class="form-label">Room Type</label>
                <select name="room_type" id="room_type" class="form-select @error('room_type') is-invalid @enderror" required>
                    <option value="regular">Regular</option>
                    <option value="premium">Premium</option>
                    <option value="deluxe">Deluxe</option>
                </select>
                @error('room_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="bed_number" class="form-label">Number of Beds</label>
                <input type="number" name="bed_number" id="bed_number" class="form-control @error('bed_number') is-invalid @enderror" required>
                @error('bed_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" role="switch" name="status" id="status" value="1">
                <label class="form-check-label" for="status">Available</label>
            </div>

            <button type="submit" class="btn btn-primary">Save Room</button>
            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
