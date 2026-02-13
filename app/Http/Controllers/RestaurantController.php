<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{

    public function dashboard()
    {
        $notifications = auth()->user()
            ->notifications()
            ->unread()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        $totalreservation = DB::table('reservations')->join('restaurants', 'reservations.restaurant_id', '=', 'restaurants.id')
        ->where('restaurants.users_id', Auth::id())->count();
        $totalRestaurant = DB::table('restaurants')->where('users_id', Auth::id())->count();    

        return view('restaurateur.dashboard', compact('notifications', 'totalreservation', 'totalRestaurant'));
    }

    public function myRestaurant()
    {
        $restaurants = Restaurant::where('users_id', auth()->id())->get();
        return view('restaurateur.myRestaurant', compact('restaurants'));
    }


    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect()->back()->with('success', 'Restaurant deleted successfully!');
    }

    public function update(Request $request, Restaurant $restaurant)
    {

        $restaurant->update($request->only('name', 'location', 'cuisine_type', 'capacity', 'horaires'));

        return redirect()->back()->with('success', 'Restaurant updated successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([    
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $fileImage = $request->file('image')->store('images', 'public');


        Restaurant::create([
            'name' => $request->name,
            'location' => $request->location,
            'cuisine_type' => $request->cuisine_type,
            'capacity' => $request->capacity,
            'horaires' => $request->horaires,
            'image' => $fileImage,
            'users_id' => auth()->id(),
        ]);



        return redirect()->back()->with('success', 'Restaurant profile created successfully!');
    }
}
