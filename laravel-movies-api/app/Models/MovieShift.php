<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieShift extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'date_time',
        'status',
    ];

    protected $dates = [
        'date_time',
    ];

    protected $casts = [
        'date_time' => 'datetime:Y-m-d H:i',
    ];
}
