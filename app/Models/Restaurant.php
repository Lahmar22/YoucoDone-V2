<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'location',
        'cuisine_type',
        'capacity',
        'horaires',
        'image',
        'users_id',
    ];

    /**
     * Users who favorited this restaurant.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favoris', 'restaurant_id', 'user_id')->withTimestamps();
    }

    /**
     * Reservations made for this restaurant.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Menus available at this restaurant.
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

}
