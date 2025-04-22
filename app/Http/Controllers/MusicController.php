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
        $events = collect([]);
        $message = '';
        
        if (session()->has('user_id')) {
            $musician = Musician::where('user_id', session('user_id'))->first();
            if ($musician) {
                $events = UpcomingEvents::where('musician_id', $musician->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                if ($events->isEmpty()) {
                    $message = "You haven't created any events yet. Start by creating your first event!";
                }
            }
        }
        
        return view('pages.events', compact('events', 'message'));
    }

    public function music()
    {
        $music = collect([]);
        $message = '';
        
        if (session()->has('user_id')) {
            $musician = Musician::where('user_id', session('user_id'))->first();
            if ($musician) {
                $music = FeaturedMusic::where('musician_id', $musician->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                if ($music->isEmpty()) {
                    $message = "You haven't shared any music yet. Share your first track with the world!";
                }
            }
        }
        
        return view('pages.music', compact('music', 'message'));
    }

    public function about()
    {
        // Get all musicians with their user data and relationships
        $musicians = Musician::with(['user', 'featured_music', 'upcoming_events'])->get();
        
        // Get the current user's musician profile if logged in
        $currentMusician = null;
        if (session()->has('user_id')) {
            $currentMusician = Musician::with(['user', 'featured_music', 'upcoming_events'])
                ->where('user_id', session('user_id'))
                ->first();
        }
        
        return view('pages.about', compact('musicians', 'currentMusician'));
    }
}
