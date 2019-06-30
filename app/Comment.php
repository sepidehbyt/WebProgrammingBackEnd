<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author', 'quality', 'packaging', 'delivery_time', 'text', 'id', 'created_at','updated_at'
    ];

    public function getComments()
    {
        return $this->belongsTo('App\Restaurant');
    }
}