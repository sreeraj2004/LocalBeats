<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FeaturedMusic;
use App\Models\UpcomingEvents;
use App\Models\Musician;
use App\Models\User;

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
        // Get all musicians with their user data
        $musicians = Musician::with('user')->get();
        
        // Get the current user's musician profile if logged in
        $currentMusician = null;
        if (session()->has('user_id')) {
            $currentMusician = Musician::with('user')->where('user_id', session('user_id'))->first();
        }
        
        return view('pages.about', compact('musicians', 'currentMusician'));
    }
}
