<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subtask extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subtasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_id', 'tag', 'status'
    ];
}
