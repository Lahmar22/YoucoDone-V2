@extends('admin.layouts.base')

@section('title', 'Profile')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h2 class="text-xl font-semibold mb-4">My Profile</h2>
            <div class="space-y-2">
                <div><strong>Name:</strong> {{ auth('admin')->user()->name }}</div>
                <div><strong>Email:</strong> {{ auth('admin')->user()->email }}</div>
            </div>
            <div class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="inline-block px-4 py-2 bg-gray-100 rounded-md">Back to dashboard</a>
            </div>
        </div>
    </div>
@endsection
