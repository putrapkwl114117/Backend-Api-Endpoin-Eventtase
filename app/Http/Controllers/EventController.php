<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Fungsi untuk membuat event baru
    public function create(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048', // validasi untuk gambar
        ]);

        // Proses upload gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('event_images', 'public');
        }

        // Buat event
        $event = Event::create([
            'organization_id' => $validated['organization_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image_path' => $imagePath, // simpan path gambar
        ]);

        // Membuat URL akses gambar yang benar
        $imageUrl = $imagePath ? asset('storage/' . $imagePath) : null;

        // Mengembalikan respons dengan URL gambar
        return response()->json([
            'message' => 'Event created successfully',
            'event' => [
                'name' => $event->name,
                'description' => $event->description,
                'image_path' => $imageUrl,  // Mengirimkan URL gambar
            ]
        ]);
    }

    // Fungsi untuk mendapatkan event berdasarkan organization_id
    public function getEventsByOrganization(Request $request, $organizationId)
    {
        // Ambil semua event yang berhubungan dengan organizationId
        $events = Event::where('organization_id', $organizationId)->get();

        // Membuat URL akses gambar yang benar untuk setiap event
        $eventsData = $events->map(function ($event) {
            $imageUrl = $event->image_path ? asset('storage/' . $event->image_path) : null;
            return [
                'name' => $event->name,
                'description' => $event->description,
                'image_path' => $imageUrl,  // Mengirimkan URL gambar
            ];
        });

        // Mengembalikan daftar event dalam format JSON
        return response()->json($eventsData);
    }
}