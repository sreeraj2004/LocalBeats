<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FeaturedMusic;
use App\Models\UpcomingEvents;

class MusicController extends Controller
{
    //
    public function index(){
        $featuredMusic = FeaturedMusic::all();
        $upcomingEvents = UpcomingEvents::all();
        return view('welcome', compact('featuredMusic', 'upcomingEvents'));
    }
}
