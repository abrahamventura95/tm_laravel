<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'habits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'tag', 'alarm', 'status'
    ];
}
