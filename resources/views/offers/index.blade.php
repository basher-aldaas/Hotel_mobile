@extends('layouts.app')

@section('title', 'Offers List')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Offers List</h2>
            <a href="{{ route('offers.create') }}" class="btn btn-success">Create Offer</a>
        </div>

        <table class="table table-hover bg-white shadow-sm">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Room</th>
                <th>Title</th>
                <th>Discount</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($offers as $offer)
                <tr onclick="window.location='{{ route('offers.show', $offer->id) }}'" style="cursor: pointer;">
                    <td>{{ $offer->id }}</td>
                    <td>{{ $offer->room->title ?? 'N/A' }}</td>
                    <td>{{ $offer->title }}</td>
                    <td>{{ $offer->discount }}%</td>
                    <td>{{ $offer->start_date }}</td>
                    <td>{{ $offer->end_date }}</td>
                    <td>
                        <a href="{{ route('offers.edit', $offer->id) }}" class="btn btn-sm btn-warning"
                           onclick="event.stopPropagation()">Edit</a>

                        <form action="{{ route('offers.destroy', $offer->id) }}" method="POST" class="d-inline"
                              onsubmit="event.stopPropagation(); return confirm('Are you sure you want to delete this offer?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>


                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No offers found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $offers->links() }}
        </div>
    </div>
@endsection
