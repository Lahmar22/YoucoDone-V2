<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'restaurant_id',
        'image',
    ];

    /**
     * Get all items for this menu
     */
    public function items()
    {
        return DB::table('mmi')
            ->join('menu_item', 'mmi.menu_item_id', '=', 'menu_item.id')
            ->where('mmi.menu_id', $this->id)
            ->select('menu_item.*')
            ->get();
    }

    /**
     * Get menu items count
     */
    public function getItemsCountAttribute()
    {
        return DB::table('mmi')
            ->where('menu_id', $this->id)
            ->count();
    }

    /**
     * Get the restaurant that owns this menu
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
