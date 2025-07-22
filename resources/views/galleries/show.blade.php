@extends('layouts.app')

@section('title', 'Gallery Details')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Gallery Details</h4>
            </div>
            <div class="card-body">

                <div class="text-center mb-4">
                    <img src="{{ asset($gallery->image) }}" alt="Gallery Image" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                </div>

                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item">
                        <strong>Image Name:</strong> {{ basename($gallery->image) }}
                    </li>
                    <li class="list-group-item">
                        <strong>Created At:</strong> {{ $gallery->created_at->format('Y-m-d H:i') }}
                    </li>
                    <li class="list-group-item">
                        <strong>Updated At:</strong> {{ $gallery->updated_at->format('Y-m-d H:i') }}
                    </li>
                </ul>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('galleries.edit', $gallery->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>

                    <form action="{{ route('galleries.destroy', $gallery->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this gallery?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('galleries.index') }}" class="btn btn-secondary">
                        ← Back to Galleries
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
