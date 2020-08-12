<?php

namespace App\Cinema\Models;

use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'turn', 'status'
    ];

    public function movies()
    {
        return $this->belongsToMany('App\Cinema\Models\Movie')->withTimestamps();
    }
}
