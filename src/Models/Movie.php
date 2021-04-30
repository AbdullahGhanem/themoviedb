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
	  	'imdb_id',
		'title',
		'overview',
		'release_date',
		'vote_average',
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

  	protected static function newFactory()
	{
    	return \Ghanem\Themoviedb\Database\Factories\MovieFactory::new();
	}
}