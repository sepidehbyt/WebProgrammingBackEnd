<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author', 'quality', 'packaging', 'delivery_time', 'text', 'restaurant_id', 'id', 'created_at','updated_at'
    ];

    public function getComments()
    {
        return $this->belongsTo('App\Restaurant');
    }
}
