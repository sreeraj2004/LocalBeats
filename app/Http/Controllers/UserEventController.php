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
        if (!session()->has('user_id')) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to book a musician.'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to book a musician.');
        }

        $validated = $request->validate([
            'musician_id' => 'required|exists:musicians,id',
            'name' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'location' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        // Check musician availability
        if (!$this->checkAvailability($validated['musician_id'], $validated['date'], $validated['start_time'], $validated['end_time'])) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The musician is not available during the selected time slot.'
                ], 422);
            }
            return back()->with('error', 'The musician is not available during the selected time slot.');
        }

        try {
            $userEvent = UserEvent::create([
                'user_id' => session('user_id'),
                'musician_id' => $validated['musician_id'],
                'name' => $validated['name'],
                'date' => $validated['date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'location' => $validated['location'],
                'description' => $validated['description']
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Booking request submitted successfully!',
                    'redirect' => route('musician.details', $validated['musician_id'])
                ]);
            }

            return redirect()->route('musician.details', $validated['musician_id'])
                ->with('success', 'Booking request submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating user event: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while submitting your booking request. Please try again.'
                ], 500);
            }
            
            return back()->with('error', 'An error occurred while submitting your booking request. Please try again.');
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

    public function show($musicianId)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Please login to book a musician.');
        }

        $musician = Musician::findOrFail($musicianId);
        return view('musicians.booking-form', compact('musician'));
    }
}
