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

    
@endsection
