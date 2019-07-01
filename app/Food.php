<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'food';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'description', 'food_set', 'id', 'created_at','updated_at'
    ];

    public function getFoods()
    {
        return $this->belongsTo('App\Restaurant');
    }
}
