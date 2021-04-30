<?php

namespace Ghanem\Themoviedb\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'overview' => $this->overview,
            'release_date' => $this->release_date,
            'vote_average' => $this->vote_average,
            'categories' => CategoryResource::collection($this->categories),
        ];
    }
}
