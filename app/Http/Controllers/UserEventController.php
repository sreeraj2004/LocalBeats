<?php

namespace App\Http\Controllers;

use App\Models\UserEvent;
use App\Models\Musician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserEventController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'musician_id' => 'required|exists:musicians,id',
                'name' => 'required|string|max:255',
                'date' => 'required|date|after:today',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
                'location' => 'required|string|max:255',
                'description' => 'required|string'
            ]);

            // Check if the musician is available
            $isAvailable = $this->checkAvailability(
                $request->musician_id,
                $request->date,
                $request->start_time,
                $request->end_time
            );

            if (!$isAvailable) {
                return response()->json([
                    'success' => false,
                    'message' => 'The musician is not available for the selected time slot.'
                ], 422);
            }

            $userEvent = UserEvent::create([
                'user_id' => Auth::id(),
                'musician_id' => $request->musician_id,
                'name' => $request->name,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'location' => $request->location,
                'description' => $request->description,
                'status' => 'pending'
            ]);

            Log::info('New event booking created', ['event_id' => $userEvent->id]);

            return response()->json([
                'success' => true,
                'message' => 'Event booking request submitted successfully.',
                'data' => $userEvent
            ]);

        } catch (\Exception $e) {
            Log::error('Error creating event booking', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.'
            ], 500);
        }
    }

    private function checkAvailability($musicianId, $date, $startTime, $endTime)
    {
        // Check for existing bookings on the same date and time
        $existingBookings = UserEvent::where('musician_id', $musicianId)
            ->where('date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->where('status', '!=', 'rejected')
            ->count();

        return $existingBookings === 0;
    }

    public function show(Musician $musician)
    {
        return view('musicians.booking-form', compact('musician'));
    }
}
