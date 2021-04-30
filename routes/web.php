<?php

use Illuminate\Support\Facades\Route;
use Ghanem\Themoviedb\Http\Controllers\MovieController;

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');