<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'order',
        'ready',
        'vote',
        'fasc',
        'hitler',
        'chancellor_elected',
        'chancellor',
        'chancellor_last',
        'president',
        'president_last',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
