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
                'description' => 'required|string',
                'music_file' => 'required|mimes:mp3,wav|max:10240', // 10MB max
            ]);

            $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            $musician = Musician::where('user_id', $user->id)->first();
            if (!$musician) {
                return response()->json(['success' => false, 'message' => 'Musician profile not found'], 404);
            }

            if ($request->hasFile('music_file')) {
                $file = $request->file('music_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Store the file in the public/music directory
                $file->move(public_path('music'), $filename);
                
                // Create a new featured music entry
                $music = new FeaturedMusic();
                $music->musician_id = $musician->id;
                $music->title = $request->title;
                $music->description = $request->description;
                $music->file_path = 'music/' . $filename;
                $music->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Music uploaded successfully',
                    'music' => $music
                ]);
            }

            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function uploadEvent(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'date' => 'required|date',
                'time' => 'required',
                'location' => 'required|string|max:255',
            ]);

            $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            $musician = Musician::where('user_id', $user->id)->first();
            if (!$musician) {
                return response()->json(['success' => false, 'message' => 'Musician profile not found'], 404);
            }

            // Create a new upcoming event entry
            $event = new UpcomingEvent();
            $event->musician_id = $musician->id;
            $event->title = $request->title;
            $event->description = $request->description;
            $event->date = $request->date;
            $event->time = $request->time;
            $event->location = $request->location;
            $event->save();

            return response()->json([
                'success' => true,
                'message' => 'Event created successfully',
                'event' => $event
            ]);
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
                
                // Define the upload path
                $uploadPath = public_path('images/profile');
                
                // Delete old photo if it exists
                if ($musician->profile_photo && file_exists($uploadPath . '/' . $musician->profile_photo)) {
                    unlink($uploadPath . '/' . $musician->profile_photo);
                }
                
                // Move the new file
                $file->move($uploadPath, $filename);
                
                // Verify the file was moved successfully
                if (!file_exists($uploadPath . '/' . $filename)) {
                    throw new \Exception('Failed to move uploaded file to destination.');
                }
                
                // Update the database
                $musician->profile_photo = $filename;
                $musician->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Profile photo updated successfully',
                    'photo_url' => asset('images/profile/' . $filename)
                ]);
            }

            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            \Log::error('Profile photo update error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Error updating profile photo. Please try again.'
            ], 500);
        }
    }
}
