@extends('layouts.app')

@section('title', 'All Galleries')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Galleries List</h2>
            <a href="{{ route('galleries.create') }}" class="btn btn-success">Create Gallery</a>
        </div>
        <table class="table table-hover bg-white shadow-sm">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($galleries as $gallery)
                <tr onclick="window.location='{{ route('galleries.show', $gallery->id) }}';" style="cursor: pointer;">
                    <td>{{ $gallery->id }}</td>
                    <td>
                        <img src="{{ asset($gallery->image) }}" alt="Gallery Image" style="width: 100px; height: auto;">
                    </td>
                    <td>
                        <a href="{{ route('galleries.edit', $gallery->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('galleries.destroy', $gallery->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this gallery?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No galleries found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $galleries->links() }}
        </div>
    </div>
@endsection
