<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function myMenu()
    {
        $restaurants = Restaurant::where('users_id', auth()->id())->select('id', 'name')->get();
        $menus = DB::table('menus')
            ->join('restaurants', 'menus.restaurant_id', '=', 'restaurants.id')
            ->select('menus.*', 'restaurants.name as restaurant_name')
            ->get();
        
        $menuItems = DB::table('menu_item')->get();
        
        return view('restaurateur.myMenu', compact('restaurants', 'menus', 'menuItems'));
    }

     public function store(Request $request)
    {
         $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $fileImage = $request->file('image')->store('images', 'public');
       
        Menu::create([
            'name' => $request->name,
            'restaurant_id' => $request->id_restaurant,
            'image' => $fileImage,
        ]);
        
        return redirect()->back()->with('success', 'Menu created successfully!');
    }

    public function itemsStore(Request $request)
    {
        
       foreach ($request->items as $item) {
            DB::table('mmi')->insert([
                'menu_id' => $request->menu_id,
                'menu_item_id' => $item,
            ]);
       }

       

        return redirect()->back()->with('success', 'Menu items added successfully!');
    }

    public function show(Menu $menu)
    {
        $items = DB::table('mmi')
            ->join('menu_item', 'mmi.menu_item_id', '=', 'menu_item.id')
            ->where('mmi.menu_id', $menu->id)
            ->select('menu_item.*')
            ->get();

        return view('restaurateur.menuItems', compact('menu', 'items'));
    }

    public function getMenuItems($menuId)
    {
        $items = DB::table('mmi')
            ->join('menu_item', 'mmi.menu_item_id', '=', 'menu_item.id')
            ->where('mmi.menu_id', $menuId)
            ->select('menu_item.id', 'menu_item.name', 'menu_item.price')
            ->get();

        return response()->json($items);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->back()->with('success', 'Menu deleted successfully!');
    }

    public function deleteItem($menuId, $itemId)
    {
        DB::table('mmi')
            ->where('menu_id', $menuId)
            ->where('menu_item_id', $itemId)
            ->delete();

        return redirect()->back()->with('success', 'Item removed from menu successfully!');
    }

    
}
