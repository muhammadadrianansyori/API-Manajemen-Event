<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ParticipantController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,id',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'phone'    => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $event = Event::findOrFail($request->event_id);

        // Cek Kuota
        $count = Participant::where('event_id', $request->event_id)->count();
        if ($count >= $event->quota) {
            return response()->json(['message' => 'Maaf, kuota event sudah penuh'], 400);
        }

        $participant = Participant::create([
            'event_id' => $request->event_id,
            'user_id'  => Auth::id(),
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'status'   => 'registered' // HARUS sesuai dengan list di migration
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendaftar event',
            'data'    => $participant
        ], 201);
    }

    // Fungsi untuk Admin mengubah status ke 'attended' atau 'cancelled'
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:registered,attended,cancelled'
        ]);

        $participant = Participant::findOrFail($id);
        $participant->update(['status' => $request->status]);

        return response()->json(['message' => 'Status peserta diperbarui']);
    }
}
