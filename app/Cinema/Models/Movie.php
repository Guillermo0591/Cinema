<?php

namespace App\Cinema\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'publication_date', 'path'
    ];

    public function turns()
    {
        return $this->belongsToMany('App\Cinema\Models\Turn')->withTimestamps();
    }
}
