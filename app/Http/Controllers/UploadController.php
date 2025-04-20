<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\FeaturedMusic;
use App\Models\UpcomingEvent;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    public function uploadMusic(Request $request)
    {
        try {
            Log::info('Music upload attempt:', [
                'artist_name' => $request->artist_name,
                'genre' => $request->genre,
                'ratings' => $request->ratings
            ]);

            $request->validate([
                'image' => 'required|image',
                'artist_name' => 'required|string',
                'genre' => 'required|string',
                'ratings' => 'required|numeric',
                'song' => 'required|mimes:mp3,wav',
            ]);

            // Save image
            $imageName = time().'_'.Str::random(5).'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            // Save song
            $songName = time().'_'.Str::random(5).'.'.$request->song->extension();
            $request->song->move(public_path('songs'), $songName);

            // Log the data before saving to DB
            Log::info('Music upload data:', [
                'image' => 'images/' . $imageName,
                'artist_name' => $request->artist_name,
                'genre' => $request->genre,
                'ratings' => $request->ratings,
                'song_path' => 'songs/' . $songName
            ]);

            // Save to DB
            $music = FeaturedMusic::create([
                'image' => 'images/' . $imageName,
                'artist_name' => $request->artist_name,
                'genre' => $request->genre,
                'ratings' => $request->ratings,
                'song_path' => 'songs/' . $songName
            ]);

            Log::info('Music saved to database with ID: ' . $music->id);

            return response()->json(['success' => true, 'message' => 'Music uploaded successfully!']);
        } catch (\Exception $e) {
            Log::error('Error uploading music: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json(['success' => false, 'message' => 'Error uploading music: ' . $e->getMessage()], 500);
        }
    }

    public function uploadEvent(Request $request)
    {
        try {
            Log::info('Event upload attempt:', [
                'name' => $request->name,
                'date' => $request->date,
                'location' => $request->location
            ]);

            $request->validate([
                'image' => 'required|image',
                'name' => 'required|string',
                'date' => 'required|date',
                'location' => 'required|string',
                'time' => 'required',
                'price' => 'required|numeric',
            ]);

            $imageName = time().'_'.Str::random(5).'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            $event = UpcomingEvent::create([
                'image' => 'images/' . $imageName,
                'name' => $request->name,
                'date' => $request->date,
                'location' => $request->location,
                'time' => $request->time,
                'price' => $request->price
            ]);

            Log::info('Event saved to database with ID: ' . $event->id);

            return response()->json(['success' => true, 'message' => 'Event added successfully!']);
        } catch (\Exception $e) {
            Log::error('Error uploading event: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json(['success' => false, 'message' => 'Error adding event: ' . $e->getMessage()], 500);
        }
    }
}
