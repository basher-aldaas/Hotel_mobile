@extends('layouts.app')

@section('title', 'Rooms List')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Rooms List</h2>
            <a href="{{ route('rooms.create') }}" class="btn btn-success">Create Room</a>
        </div>

        <table class="table table-hover bg-white shadow-sm">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Type</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($rooms as $room)
                <tr onclick="window.location='{{ route('rooms.show', $room->id) }}'" style="cursor: pointer;">
                    <td>{{ $room->id }}</td>
                    <td>
                        <img src="{{ asset($room->image) }}" alt="Room Image" style="width: 100px;">
                    </td>
                    <td>{{ $room->title }}</td>
                    <td>{{ ucfirst($room->room_type) }}</td>
                    <td>${{ $room->price }}</td>
                    <td>
                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this room?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No rooms found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $rooms->links() }}
        </div>
    </div>
@endsection
