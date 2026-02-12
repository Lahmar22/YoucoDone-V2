@extends('admin.layouts.base')

@section('title', 'Restaurants')

@section('content')
    

    <div class="mt-8 bg-white p-6 rounded-2xl shadow-sm">
        <h3 class="font-semibold mb-4">Recent Restaurants</h3>
        
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Restaurant</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Cuisine</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Capacity</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Location</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @foreach($restaurants as $restaurant)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $restaurant->image) }}" class="w-12 h-12 rounded-xl object-cover bg-gray-100">
                                    <span class="font-bold text-brand-dark">{{ $restaurant->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-orange-100 text-brand-orange text-xs font-bold px-2.5 py-1 rounded-lg">{{ $restaurant->cuisine_type }}</span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-600">{{$restaurant->capacity}} Seats</td>
                            <td class="px-6 py-4 text-gray-500">{{$restaurant->location}}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    
                                    <form action="{{ route('restaurants.destroy', $restaurant->id) }}" method="POST" onsubmit="return confirm('Delete this restaurant?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"><i data-lucide="trash-2" class="w-5 h-5"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
