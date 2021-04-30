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
        $data =  Movie::when($category_id, function($query) use($category_id) {
    		return $query->whereHas('categories', function($q) use($category_id){
			    $q->where('category_id', $category_id);
			});
    	})->get();

    	return MovieResource::collection($data);
    }
}