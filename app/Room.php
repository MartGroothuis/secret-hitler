<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'draw_pile',
        'discard_pile',
        'cards_pile',
        'lib_board',
        'fasc_board',
        'nein_counter',
        'vote',
    ];
    protected $casts = [
        'draw_pile' => 'array',
        'discard_pile' => 'array',
        'cards_pile' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
