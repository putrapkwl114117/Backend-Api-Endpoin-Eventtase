<?php

namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
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

        return response()->json(['message' => 'Event created successfully', 'event' => $event]);
    }
}