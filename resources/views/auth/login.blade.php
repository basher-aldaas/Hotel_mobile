@extends('layouts.auth')

@section('title', 'Login')

@section('content')

    <div class="background-image"></div>

    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card p-4 shadow card-transparent" style="width: 400px;">
            <h3 class="text-center mb-3">Login</h3>

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                <button class="btn btn-dark w-100">Login</button>
            </form>
        </div>
    </div>
@endsection
