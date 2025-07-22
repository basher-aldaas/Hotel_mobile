@extends('layouts.app')

@section('title', 'Create Gallery')

@section('content')
    <div class="container">
        <h2 class="mb-4">Create New Gallery</h2>

        <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="image" class="form-label">Gallery Image</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" required>

                @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save Gallery</button>
            <a href="{{ route('galleries.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
