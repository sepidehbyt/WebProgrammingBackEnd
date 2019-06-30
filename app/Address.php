<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city', 'area', 'address_line', 'restaurant_id', 'id', 'created_at','updated_at'
    ];

    public function getAddress()
    {
        return $this->belongsTo('App\Restaurant');
    }

}