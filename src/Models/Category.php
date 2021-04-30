<?php

namespace Ghanem\Themoviedb\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
	  	'name',
		'themoviedb_id'
  	];

    /**
     * movies function
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    } 
}