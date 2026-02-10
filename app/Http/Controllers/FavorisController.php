<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    /**
     * Show the authenticated user's favorite restaurants.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $restaurants = $user ? $user->favoris()->get() : collect();

        // If you have a view for showing favorites, return it. Otherwise return JSON.
        if (view()->exists('client.favorites')) {
            return view('client.favorites', compact('restaurants'));
        }

        return response()->json(['favorites' => $restaurants]);
    }

    /**
     * Toggle favorite status for the authenticated user on a restaurant.
     */
    public function toggle(Request $request, $restaurantId)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $restaurant = Restaurant::findOrFail($restaurantId);

        $exists = $user->favoris()->where('restaurants.id', $restaurantId)->exists();

        if ($exists) {
            $user->favoris()->detach($restaurantId);
            return back()->with('status', 'Removed from favorites');
        }

        $user->favoris()->attach($restaurantId);
        return back()->with('status', 'Added to favorites');
    }
}
