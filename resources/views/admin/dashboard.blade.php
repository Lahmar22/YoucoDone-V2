@extends('admin.layouts.base')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h3 class="text-sm text-gray-500 uppercase font-bold">Total Restaurants</h3>
            <div class="mt-4 text-3xl font-bold">{{ \App\Models\Restaurant::count() }}</div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h3 class="text-sm text-gray-500 uppercase font-bold">Total Users</h3>
            <div class="mt-4 text-3xl font-bold">{{ \App\Models\User::count() }}</div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h3 class="text-sm text-gray-500 uppercase font-bold">Favorites</h3>
            <div class="mt-4 text-3xl font-bold">{{ \DB::table('favoris')->count() }}</div>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-2xl shadow-sm">
        <h3 class="font-semibold mb-4">Recent Restaurants</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach(\App\Models\Restaurant::latest()->take(6)->get() as $r)
                <div class="p-4 border rounded-lg">
                    <div class="font-medium">{{ $r->name }}</div>
                    <div class="text-sm text-gray-500">{{ $r->location }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
