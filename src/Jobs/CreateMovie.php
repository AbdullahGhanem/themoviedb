<?php

namespace Ghanem\Themoviedb\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ghanem\Themoviedb\Models\Movie;

class CreateMovie implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    public function handle()
    {
        $movie = Movie::firstOrCreate([
            'id' => $this->item['id'],
        ],[ 
            'id' => $this->item['id'],
            'title' => $this->item['title'],
            'overview' => $this->item['overview'],
            'imdb_id' => $this->item['imdb_id'] ?? null,
            'release_date' => $this->item['release_date'],
            'vote_average' => $this->item['vote_average'],
            'popularity' => $this->item['popularity'],
        ]);
        $movie->categories()->sync($this->item['genre_ids']);
    }
}