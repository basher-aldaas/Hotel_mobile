@extends('layouts.app')

@section('title', 'Edit Gallery')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Gallery</h2>

        <form action="{{ route('galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="current_image" class="form-label">Current Image</label><br>
                <img src="{{ asset($gallery->image) }}" alt="Current Image" style="max-width: 200px; height: auto;">
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Replace Image (optional)</label>
                <input type="file" name="image" id="image"
                       class="form-control @error('image') is-invalid @enderror">

                @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Gallery</button>
            <a href="{{ route('galleries.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
