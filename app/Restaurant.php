<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'logo', 'opening_time', 'closing_time', 'average_rate', 'address_id', 'id', 'created_at','updated_at'
    ];

    public function getComments()
    {
        return $this->hasMany('App\Comment');
    }

    public function getCategories()
    {
        return $this->hasMany('App\Category');
    }

    public function getFoods()
    {
        return $this->hasMany('App\Food');
    }

    public function getAddress()
    {
        return $this->belongsTo('App\Address');
    }
}