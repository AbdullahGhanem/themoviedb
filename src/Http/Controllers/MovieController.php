<?php

namespace Ghanem\Themoviedb\Http\Controllers;

use Ghanem\Themoviedb\Http\Resources\MovieResource;
use Ghanem\Themoviedb\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
    	$category_id = $request->category_id;
        $query =  Movie::when($category_id, function($query) use($category_id) {
    		return $query->whereHas('categories', function($q) use($category_id){
			    $q->where('category_id', $category_id);
			});
    	});

        $query = $this->sortMoviesQuery($query, $request);

		$data = $query->get();
    	return MovieResource::collection($data);
    }

    protected function sortMoviesQuery($query, $request)
    {
        $lookups = [
            'popular' => 'popularity',
            'rated' => 'vote_average',            
            'popularity' => 'popularity',
            'vote_average' => 'vote_average',
        ];

        $sorts = array_filter(array_map(function ($value){
            if(strpos($value, '|') !== false)
                return explode('|', $value);
        }, array_keys($request->all())));

        foreach($sorts as $sort){
            if($column= $lookups[$sort[0]]?? null)
                $query->orderBy($column, $sort[1]);
        }
        return $query;  
    }

}