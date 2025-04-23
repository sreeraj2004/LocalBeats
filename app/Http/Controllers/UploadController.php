<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Musician;
use App\Models\FeaturedMusic;
use App\Models\UpcomingEvent;

class UploadController extends Controller
{
    public function uploadMusic(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'file' => 'required|mimes:mp3,wav|max:10240', // 10MB max
            ]);

            if (!session()->has('user_id')) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            $musician = Musician::where('user_id', session('user_id'))->first();
            if (!$musician) {
                return response()->json(['success' => false, 'message' => 'Musician profile not found'], 404);
            }

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Store the file in the storage/app/public/music directory
                $path = $request->file('file')->storeAs('music', $filename, 'public');
                
                // Create a new featured music entry
                $music = new FeaturedMusic();
                $music->musician_id = $musician->id;
                $music->artist_name = $request->title;
                $music->genre = $request->genre ?? 'Unknown';
                $music->ratings = 0;
                $music->song_path = $path;
                
                // Handle cover image if provided
                if ($request->hasFile('cover_image')) {
                    $coverImage = $request->file('cover_image');
                    $coverFilename = time() . '_' . $coverImage->getClientOriginalName();
                    $coverPath = $coverImage->storeAs('music_covers', $coverFilename, 'public');
                    $music->image = $coverPath;
                }
                
                $music->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Music uploaded successfully',
                    'music' => [
                        'id' => $music->id,
                        'artist_name' => $music->artist_name,
                        'genre' => $music->genre,
                        'ratings' => $music->ratings,
                        'song_path' => $music->song_path,
                        'image' => $music->image
                    ]
                ]);
            }

            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            \Log::error('Music upload error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function uploadEvent(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'date' => 'required|date',
                'time' => 'required',
                'location' => 'required|string|max:255',
                'price' => 'required|numeric',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            if (!session()->has('user_id')) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            $musician = Musician::where('user_id', session('user_id'))->first();
            if (!$musician) {
                return response()->json(['success' => false, 'message' => 'Musician profile not found'], 404);
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Store the file in the storage/app/public/events directory
                $path = $request->file('image')->storeAs('events', $filename, 'public');
                
                // Create a new upcoming event entry
                $event = new UpcomingEvent();
                $event->musician_id = $musician->id;
                $event->name = $request->title;
                $event->date = $request->date;
                $event->time = $request->time;
                $event->location = $request->location;
                $event->price = $request->price;
                $event->image = $path;
                $event->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Event created successfully',
                    'event' => $event
                ]);
            }

            return response()->json(['success' => false, 'message' => 'No image uploaded'], 400);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateProfilePhoto(Request $request)
    {
        try {
            if (!session()->has('user_id')) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            $request->validate([
                'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $musician = Musician::where('user_id', session('user_id'))->first();
            if (!$musician) {
                return response()->json(['success' => false, 'message' => 'Musician profile not found'], 404);
            }

            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Store the file in the storage/app/public/profile_photos directory
                $path = $request->file('profile_photo')->storeAs('profile_photos', $filename, 'public');
                
                if (!$path) {
                    throw new \Exception('Failed to store the file');
                }
                
                // Update the database
                $musician->profile_photo = $path;
                $musician->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Profile photo updated successfully',
                    'photo_url' => asset('storage/' . $path)
                ]);
            }

            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            \Log::error('Profile photo update error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
