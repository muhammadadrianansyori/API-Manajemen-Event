<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Helper untuk mengambil ID user secara aman
     */
    private function getUserId()
    {
        return Auth::guard('api')->id();
    }

    /**
     * 1. GET /api/events (Daftar Event dengan Filter & Search)
     */
    public function index(Request $request) // Tambahkan parameter Request
    {
        // Gunakan query builder agar bisa difilter
        $query = Event::with(['category', 'creator']);

        // A. Filter berdasarkan Category ID
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // B. Tambahan: Filter berdasarkan Search (Judul Event)
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar event berhasil diambil',
            'count'   => $events->count(),
            'data'    => $events
        ], 200);
    }

    /**
     * 2. POST /api/events (Tambah Event)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'event_date'  => 'required|date',
            'quota'       => 'required|integer|min:1',
            'location'    => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $userId = $this->getUserId();

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Token tidak valid.'
            ], 401);
        }

        $event = Event::create([
            'title'       => $request->title,
            'event_date'  => $request->event_date,
            'quota'       => $request->quota,
            'location'    => $request->location,
            'category_id' => $request->category_id,
            'created_by'  => $userId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil dibuat',
            'data'    => $event
        ], 201);
    }

    /**
     * 3. GET /api/events/{id} (Detail Event)
     */
    public function show($id)
    {
        $event = Event::with(['category', 'creator'])->find($id);

        if (!$event) {
            return response()->json(['success' => false, 'message' => 'Event tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $event], 200);
    }

    /**
     * 4. PUT /api/events/{id} (Update Event)
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['success' => false, 'message' => 'Event tidak ditemukan'], 404);
        }

        if ($event->created_by != $this->getUserId()) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title'       => 'sometimes|string|max:255',
            'event_date'  => 'sometimes|date',
            'quota'       => 'sometimes|integer|min:1',
            'location'    => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $event->update($request->all());

        return response()->json(['success' => true, 'message' => 'Event diperbarui', 'data' => $event]);
    }

    /**
     * 5. DELETE /api/events/{id} (Hapus Event)
     */
    public function destroy($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['success' => false, 'message' => 'Event tidak ditemukan'], 404);
        }

        if ($event->created_by != $this->getUserId()) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses'], 403);
        }

        $event->delete();

        return response()->json(['success' => true, 'message' => 'Event berhasil dihapus']);
    }
}
