<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FeaturedMusic;
use App\Models\UpComingEvents;
use App\Models\Musician;
use App\Models\User;

class MusicController extends Controller
{
    //
    public function index(){
        $events = UpComingEvents::with('musician')->orderBy('date', 'asc')->get();
        $music = FeaturedMusic::with('musician')->orderBy('created_at', 'desc')->get();
        
        // Get current user's musician profile if logged in
        $currentMusician = null;
        $isLoggedIn = false;
        $userId = null;
        
        if (session()->has('user_id')) {
            $isLoggedIn = true;
            $userId = session('user_id');
            $currentMusician = Musician::where('user_id', $userId)->first();
        }
        
        return view('home', compact('events', 'music', 'currentMusician', 'isLoggedIn', 'userId'));
    }

    public function home()
    {
        return $this->index();
    }

    public function musicians()
    {
        // Get all musicians with their user data only
        $musicians = Musician::with(['user'])->get();
        
        return view('pages.musicians', compact('musicians'));
    }

    public function musicianDetails($id)
    {
        try {
            $musician = Musician::with([
                'user',
                'featured_music' => function($query) {
                    $query->orderBy('created_at', 'desc')->limit(2);
                },
                'upcoming_events' => function($query) {
                    $query->orderBy('date', 'desc')->limit(2);
                }
            ])->findOrFail($id);
            
            return view('pages.musician-details', compact('musician'));
        } catch (\Exception $e) {
            \Log::error('Error in musicianDetails method: ' . $e->getMessage());
            return redirect()->route('musicians')->with('error', 'Musician not found');
        }
    }

    public function events()
    {
        try {
            \Log::info('Events method called');
            $events = collect([]);
            $message = '';
            $isLoggedIn = false;
            $userId = null;
            
            if (session()->has('user_id')) {
                \Log::info('User is authenticated');
                $isLoggedIn = true;
                $userId = session('user_id');
                $user = User::find($userId);
                $musician = Musician::where('user_id', $user->id)->first();
                
                if ($musician) {
                    \Log::info('Musician found', ['musician_id' => $musician->id]);
                    // Show only events created by this musician
                    $events = UpComingEvents::where('musician_id', $musician->id)
                        ->orderBy('date', 'desc')
                        ->get();
                    
                    if ($events->isEmpty()) {
                        $message = "You haven't created any events yet. Start by creating your first event!";
                    }
                } else {
                    $message = "You need to be a musician to view events.";
                }
            } else {
                $message = "Please log in to view events.";
            }
            
            \Log::info('Returning events view', [
                'events_count' => $events->count(),
                'is_logged_in' => $isLoggedIn,
                'user_id' => $userId
            ]);
            return view('pages.events', compact('events', 'message', 'isLoggedIn', 'userId'));
        } catch (\Exception $e) {
            \Log::error('Error in events method: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function music()
    {
        try {
            \Log::info('Music method called');
            $music = collect([]);
            $message = '';
            
            if (session()->has('user_id')) {
                \Log::info('User is authenticated');
                $user = User::find(session('user_id'));
                $musician = Musician::where('user_id', $user->id)->first();
                
                if ($musician) {
                    \Log::info('Musician found', ['musician_id' => $musician->id]);
                    // Show only music created by this musician
                    $music = FeaturedMusic::where('musician_id', $musician->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
                    
                    if ($music->isEmpty()) {
                        $message = "You haven't shared any music yet. Share your first track with the world!";
                    }
                } else {
                    $message = "You need to be a musician to view music.";
                }
            } else {
                $message = "Please log in to view music.";
            }
            
            \Log::info('Returning music view', ['music_count' => $music->count()]);
            return view('pages.music', compact('music', 'message'));
        } catch (\Exception $e) {
            \Log::error('Error in music method: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

            if (!session()->has('user_id')) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            $user = User::find(session('user_id'));
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Store the file in the storage/app/public directory
                $path = $request->file('profile_photo')->storeAs('profile_photos', $filename, 'public');
                
                // Update the user's profile_photo field in the database with the relative path
                $user->profile_photo = $path;
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Profile photo updated successfully',
                    'photo_url' => asset('storage/' . $path)
                ]);
            }

            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function allEvents()
    {
        try {
            \Log::info('All Events method called');
            $events = UpComingEvents::with('musician')
                ->orderBy('date', 'desc')
                ->get();
            
            $message = '';
            if ($events->isEmpty()) {
                $message = "No events available at the moment.";
            }

            // Check if user is logged in
            $isLoggedIn = session()->has('user_id');
            $userId = session('user_id');
            
            \Log::info('Returning all events view', [
                'events_count' => $events->count(),
                'is_logged_in' => $isLoggedIn,
                'user_id' => $userId
            ]);
            
            return view('pages.events', compact('events', 'message', 'isLoggedIn', 'userId'));
        } catch (\Exception $e) {
            \Log::error('Error in allEvents method: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function allMusic()
    {
        try {
            \Log::info('All Music method called');
            $music = FeaturedMusic::with('musician')
                ->orderBy('created_at', 'desc')
                ->get();
            
            $message = '';
            if ($music->isEmpty()) {
                $message = "No music available at the moment.";
            }
            
            // Check if user is logged in
            $isLoggedIn = session()->has('user_id');
            $userId = session('user_id');
            
            \Log::info('Returning all music view', [
                'music_count' => $music->count(),
                'is_logged_in' => $isLoggedIn,
                'user_id' => $userId
            ]);
            
            return view('pages.music', compact('music', 'message', 'isLoggedIn', 'userId'));
        } catch (\Exception $e) {
            \Log::error('Error in allMusic method: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
