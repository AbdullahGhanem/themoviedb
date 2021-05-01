<?php

namespace Ghanem\Themoviedb\Console;

use Ghanem\Themoviedb\Jobs\CreateMovie;
use Ghanem\Themoviedb\Models\Category;
use Ghanem\Themoviedb\Models\Movie;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ThemoviedbSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'themoviedb:seed {type}';

    protected $key;

    protected $num_of_records;

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
        $this->num_of_records = config('themoviedb.num_of_records');
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
    
    /**
     * Seed Top Rated Movies.
     *
     * @return void
     */
    private function SeedTopRatedMovies()
    {
        $this->info('Seeding Top Rated Movies');

        $pages = ($this->num_of_records / 20 > 1) ? round($this->num_of_records / 20) : 1;
        $number_items = $this->num_of_records % 20;

        foreach (range(1, $pages) as $page) {
            $client = new Client();
            $data = json_decode($client->get("https://api.themoviedb.org/3/movie/top_rated?api_key=$this->key&page=$page")->getBody(), true)['results'];

            if($number_items > 0)
                $this->createMovies($data, $number_items);
            else
                $this->createMovies($data, $number_items);
            
        }
    }    
    
    /**
     * Seed Recently Movies.
     *
     * @return void
     */
    private function SeedRecentlyMovies()
    {
        $this->info('Seeding Recently Movies');
    }

    /**
     * create Movies.
     *
     * @return array
     */
    private function createMovies($movies, $limit_number=null)
    {
        foreach ($movies as $key => $movie) {
            if($key+1 <= $limit_number || $limit_number == null){
                $this->createMovie($movie);
            }
        }
    }

    /**
     * create Movie.
     *
     * @return array
     */
    private function createMovie($item)
    {
        if(config('themoviedb.enable_queue')){
            dispatch(new CreateMovie($item));
        }else{
            $movie = Movie::firstOrCreate([
                'id' => $item['id'],
            ],[ 
                'id' => $item['id'],
                'title' => $item['title'],
                'overview' => $item['overview'],
                'imdb_id' => $item['imdb_id'] ?? null,
                'release_date' => $item['release_date'],
                'vote_average' => $item['vote_average'],
                'popularity' => $item['popularity'],
            ]);
            $movie->categories()->sync($item['genre_ids']);
        }
    }

    /**
     * Seed Genres.
     *
     * @return array
     */
    private function SeedGenres()
    {
        $this->info('Seeding Top Rated Movies');
        $client = new Client();
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