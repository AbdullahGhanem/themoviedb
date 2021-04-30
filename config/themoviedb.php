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

    'prefix' => '/',

	'middleware' => ['web'],
];