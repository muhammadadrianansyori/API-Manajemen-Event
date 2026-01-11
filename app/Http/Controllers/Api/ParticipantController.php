<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class ParticipantController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'phone'    => 'nullable|string|max:15', // Optional phone number validation
        ]);

        // Find the event or fail
        $event = Event::findOrFail($request->event_id);

        // Check event quota
        if ($event->participants()->count() >= $event->quota) {
            return response()->json([
                'message' => 'The event is fully booked.'
            ], 422);
        }

        // Create a new participant
        $participant = Participant::create([
            'event_id' => $event->id,
            'user_id'  => Auth::check() ? Auth::id() : null, // Check if user is authenticated
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'status'   => 'registered',
        ]);

        // Return success response
        return response()->json([
            'message' => 'Successfully registered for the event.',
            'data'    => $participant
        ], 201);
    }
}
