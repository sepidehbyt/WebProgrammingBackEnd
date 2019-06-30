<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'id', 'created_at','updated_at'
    ];

    public function getCategories()
    {
        return $this->belongsTo('App\Restaurant');
    }
}