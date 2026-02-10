<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favoris extends Model
{
    protected $table = 'favoris';

    protected $fillable = [
        'user_id',
        'restaurant_id',
    ];

    /**
     * The user who created the favorite.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The restaurant that was favorited.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
}
