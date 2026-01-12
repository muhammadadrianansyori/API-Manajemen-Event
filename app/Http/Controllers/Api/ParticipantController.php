<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\LogHelper; // Import Helper Log

class ParticipantController extends Controller
{
    /**
     * Admin: Melihat semua daftar peserta.
     */
    public function index()
    {
        $participants = Participant::with(['event', 'user'])->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar semua peserta berhasil diambil',
            'data'    => $participants
        ]);
    }

    /**
     * User: Mendaftar ke Event.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,id',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'phone'    => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        // 2. Cek apakah user sudah terdaftar di event ini
        $alreadyRegistered = Participant::where('event_id', $request->event_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($alreadyRegistered) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah terdaftar di event ini!'
            ], 400);
        }

        // 3. Cek Kuota Event
        $event = Event::findOrFail($request->event_id);
        $count = Participant::where('event_id', $request->event_id)->count();

        if ($count >= $event->quota) {
            return response()->json([
                'success' => false,
                'message' => 'Maaf, kuota event "' . $event->title . '" sudah penuh!'
            ], 400);
        }

        // 4. Simpan Data
        $participant = Participant::create([
            'event_id' => $request->event_id,
            'user_id'  => Auth::id(),
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'status'   => 'registered'
        ]);

        // --- PINDAHKAN LOG KE SINI ---
        if ($participant) {
            LogHelper::saveLog('Mendaftar Event', 'User ' . Auth::user()->name . ' mendaftar ke event: ' . $event->title);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendaftar ke event',
            'data'    => $participant
        ], 201);
    }

    /**
     * User: Melihat pendaftaran saya sendiri.
     */
    public function myRegistrations()
    {
        $data = Participant::with('event')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar event yang diikuti',
            'data'    => $data
        ]);
    }

    /**
     * Admin: Update Status Peserta
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:registered,attended,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $participant = Participant::findOrFail($id);
        $participant->update(['status' => $request->status]);

        // Tambahkan Log Update Status
        LogHelper::saveLog('Update Status Peserta', 'Status peserta ID ' . $id . ' diubah menjadi ' . $request->status);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah menjadi ' . $request->status,
            'data'    => $participant
        ]);
    }

    /**
     * Admin: Detail Peserta.
     */
    public function show($id)
    {
        $participant = Participant::with(['event', 'user'])->find($id);

        if (!$participant) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $participant
        ]);
    }

    /**
     * Admin: Hapus Peserta.
     */
    public function destroy($id)
    {
        $participant = Participant::find($id);

        if (!$participant) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Simpan Log sebelum dihapus
        LogHelper::saveLog('Hapus Peserta', 'Admin menghapus peserta ID: ' . $id);

        $participant->delete();

        return response()->json([
            'success' => true,
            'message' => 'Peserta berhasil dihapus'
        ]);
    }
}
