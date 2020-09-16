<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'appointment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'tag', 'place','topic', 'status', 'time'
    ];
}
