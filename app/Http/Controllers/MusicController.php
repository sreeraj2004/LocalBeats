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

    public function home()
    {
        return view('pages.home');
    }

    public function musicians()
    {
        return view('pages.musicians');
    }

    public function events()
    {
        return view('pages.events');
    }

    public function music()
    {
        return view('pages.music');
    }

    public function about()
    {
        return view('pages.about');
    }
}
