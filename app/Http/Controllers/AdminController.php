<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class AdminController extends Controller
{
    public function restaurants()
    {
        $restaurants = Restaurant::all();
        return view('admin.restaurants', compact('restaurants'));
    }
}
