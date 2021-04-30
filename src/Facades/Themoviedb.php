<?php

namespace Ghanem\Themoviedb\Facades;

use Illuminate\Support\Facades\Facade;

class Themoviedb extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'themoviedb';
    }
}