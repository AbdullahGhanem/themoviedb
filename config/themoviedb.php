<?php

return [
    /*
    |--------------------------------------------------------------------------
    | api key for themoviedb
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for when a location is not found
    | for the IP provided.
    |
    */
    'key' => env('THEMOVIEDB_KEY', ''),

    'num_of_records' => env('THEMOVIEDB_NUM_OF_RECORDS', 98),

    'prefix' => '/',

	'middleware' => ['web'],

    'enable_queue' => env('THEMOVIEDB_ENABLE_QUEUE', false),
];