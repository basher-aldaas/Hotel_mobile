@extends('layouts.app')

@section('title' , 'Dashboard')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary">
                <h4 class="mb-0">Dashboard</h4>
            </div>
            <div class="card-body">
                <p>Welcome in your dashboard ,{{auth()->user()->name}}!</p>
                <p>Here you can control of all system</p>
            </div>
        </div>
    </div>
@endsection
