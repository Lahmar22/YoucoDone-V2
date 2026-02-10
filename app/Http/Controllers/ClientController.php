<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Menu;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display all restaurants and their menus for clients.
     */
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('client.restaurants.index', ['restaurants' => $restaurants]);
    }

    /**
     * Display a specific restaurant with its menus.
     */
    public function showRestaurant($restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        $menus = Menu::where('restaurant_id', $restaurantId)->get();
        
        return view('client.restaurants.show', [
            'restaurant' => $restaurant,
            'menus' => $menus,
        ]);
    }

    /**
     * Display menu items for a specific menu.
     */
    public function showMenu($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $items = $menu->items();
        
        return view('client.menus.show', [
            'menu' => $menu,
            'items' => $items,
        ]);
    }
}
