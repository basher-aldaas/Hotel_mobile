@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">User Details</h4>
            </div>
            <div class="card-body">

                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                    <li class="list-group-item"><strong>Phone:</strong> {{ $user->phone }}</li>
                    <li class="list-group-item"><strong>Wallet:</strong> {{ $user->wallet }}</li>
                    <li class="list-group-item"><strong>Email Verified At:</strong>
                        {{ $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i') : 'Not Verified' }}
                    </li>
                    <li class="list-group-item"><strong>Role:</strong> {{ $user->role == 1 ? 'Admin' : 'User' }}</li>
                    <li class="list-group-item"><strong>Created At:</strong> {{ $user->created_at->format('Y-m-d H:i') }}</li>
                    <li class="list-group-item"><strong>Updated At:</strong> {{ $user->updated_at->format('Y-m-d H:i') }}</li>
                </ul>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>

                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>

                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
