<?php

namespace Ghanem\Themoviedb\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    // Disable Laravel's mass assignment protection
    protected $guarded = [];

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'title',
        'overview',
        'release_date',
        'vote_average',
        'popularity',
    ];

    /**
    * categories function
    *
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}