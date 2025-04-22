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
        $events = UpcomingEvents::orderBy('date', 'asc')->get();
        $music = FeaturedMusic::with('musician')->orderBy('created_at', 'desc')->get();
        return view('pages.home', compact('events', 'music'));
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

    public function updateProfilePhoto(Request $request)
    {
        try {
            $request->validate([
                'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Store the file in the public/profile_photos directory
                $file->move(public_path('profile_photos'), $filename);
                
                // Update the user's profile_photo field in the database
                $user->profile_photo = 'profile_photos/' . $filename;
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Profile photo updated successfully',
                    'photo_url' => asset($user->profile_photo)
                ]);
            }

            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
