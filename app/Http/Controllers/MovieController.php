<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        $menu = "movie";
        $movies = Movie::with('genre')->orderBy('id_movie')->get();
        $genres = Genre::with('movies')->orderBy('id_gendre')->get();
        return view("movie", compact("menu", "movies", "genres"));
    }
}
