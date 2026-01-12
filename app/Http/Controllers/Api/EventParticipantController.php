<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participant;
use Tymon\JWTAuth\Facades\JWTAuth;

class EventParticipantController extends Controller
{
    public function join($id)
    {
        // Gunakan JWTAuth untuk ambil user
        $user = JWTAuth::parseToken()->authenticate();

        $event = Event::findOrFail($id);

        // Cek apakah user sudah join
        if(Participant::where('event_id', $id)->where('user_id', $user->id)->exists()){
            return response()->json(['message'=>'Anda sudah terdaftar di event ini'],409);
        }

        // Buat participant baru
        $participant = Participant::create([
            'event_id' => $id,
            'user_id'  => $user->id,
            'name'     => $user->name,
            'email'    => $user->email,
            'phone'    => $user->phone ?? null,
            'status'   => 'registered'
        ]);

        return response()->json(['message'=>'Berhasil join event','data'=>$participant],201);
    }

    public function participants($id)
    {
        $event = Event::with('participants')->find($id);
        if(!$event){
            return response()->json(['message'=>'Event tidak ditemukan'],404);
        }

        return response()->json(['message'=>'Daftar peserta','data'=>$event->participants]);
    }
}
