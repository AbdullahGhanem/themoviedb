<?php

namespace Ghanem\Themoviedb\Console;

use Ghanem\Themoviedb\Models\Category;
use Ghanem\Themoviedb\Models\Movie;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
// use GuzzleHttp\Client;

class ThemoviedbSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'themoviedb:seed {type}';

    protected $key;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'seed the Themoviedb';

    /**
     * Themoviedb Seed construct.
     *
     * @return void
     */
    public function __construct()
    {
        $this->key = config('themoviedb.key');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->SeedGenres();

        $this->info('Seeding Themoviedb...');
        $type = $this->argument('type');
        switch ($type) {           
            case 'top_rated_movies':
                $this->SeedTopRatedMovies();
                break;
            case 'recently_movies':
                $this->SeedRecentlyMovies();
                break;
            default:
                $type = $this->choice(
                    'type is not exist please chose',
                    ['top_rated_movies', 'recently_movies'],
                    'top_rated_movies'
                );
                if($type == 'top_rated_movies'){
                    $this->SeedTopRatedMovies();
                }else{
                    $this->SeedRecentlyMovies();
                }
                break;
        }
    }
    
    private function SeedTopRatedMovies()
    {
        $this->info('Seeding Top Rated Movies');
        $client = new \GuzzleHttp\Client();
        $data = json_decode($client->get('https://api.themoviedb.org/3/movie/top_rated?api_key='.$this->key)->getBody(), true)['results'];

        $this->createMovies($data);
    }    

    private function SeedRecentlyMovies()
    {
        $this->info('Seeding Recently Movies');
    }

    /**
     * create Movies.
     *
     * @return array
     */
    private function createMovies($movies)
    {
        foreach ($movies as $movie) {
            $this->createMovie($movie);
        }
    }

    /**
     * create Movie.
     *
     * @return array
     */
    private function createMovie($item)
    {
        $movie = Movie::firstOrCreate([
            'id' => $item['id'],
        ],[ 
            'id' => $item['id'],
            'title' => $item['title'],
            'overview' => $item['overview'],
            'imdb_id' => $item['imdb_id'] ?? null,
            'release_date' => $item['release_date'],
            'vote_average' => $item['vote_average'],
        ]);
        $movie->categories()->sync($item['genre_ids']);
    }

    /**
     * Seed Genres.
     *
     * @return array
     */
    private function SeedGenres()
    {
        $this->info('Seeding Top Rated Movies');
        $client = new \GuzzleHttp\Client();
        $data = json_decode($client->get('https://api.themoviedb.org/3//genre/movie/list?api_key='.$this->key)->getBody(), true)['genres'];

        foreach($data as $item){
            Category::firstOrCreate([
                'id' => $item['id'],
            ],[ 
                'id' => $item['id'],
                'name' => $item['name'],
            ]);
        }
    } 
}