<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'tag', 'priority', 'status'
    ];
}
