<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habitday extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'habitdays';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'habit_id', 'tag', 'frecuency', 'day', 'time'
    ];
}
