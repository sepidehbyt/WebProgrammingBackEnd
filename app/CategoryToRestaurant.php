<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryToRestaurant extends Model
{
    protected $table = 'category_to_restaurant';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'restaurant_id', 'category_id', 'id', 'created_at','updated_at'
    ];

    public function getRestaurants()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function getCategories()
    {
        return $this->belongsTo('App\Category');
    }
}
