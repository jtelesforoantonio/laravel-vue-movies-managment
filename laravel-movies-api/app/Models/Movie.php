<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'publication_date',
        'status',
    ];

    protected $dates = [
        'deleted_at',
        'publication_date',
    ];

    protected $casts = [
        'publication_date' => 'date:Y-m-d',
    ];

    /**
     * Movie Shifts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shifts()
    {
        return $this->hasMany(MovieShift::class);
    }
}
