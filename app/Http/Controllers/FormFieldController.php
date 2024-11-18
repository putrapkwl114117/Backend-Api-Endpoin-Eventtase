<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\FormField;
use Illuminate\Http\Request;

class FormFieldController extends Controller
{
    // Fungsi untuk menambahkan banyak field ke event tertentu
    public function create(Request $request, $eventId)
    {
        // Validasi array form fields
        $validated = $request->validate([
            'fields' => 'required|array',
            'fields.*.type' => 'required|string',
            'fields.*.label' => 'required|string',
            'fields.*.required' => 'boolean',
            'fields.*.options' => 'nullable|array',
        ]);

        // Temukan event
        $event = Event::findOrFail($eventId);

        // Tambahkan setiap field ke event
        $formFields = [];
        foreach ($validated['fields'] as $fieldData) {
            // Cek apakah 'options' ada dan bukan null
            $options = isset($fieldData['options']) ? json_encode($fieldData['options']) : null;

            $formFields[] = $event->formFields()->create([
                'type' => $fieldData['type'],
                'label' => $fieldData['label'],
                'required' => $fieldData['required'] ?? false,
                'options' => $options,
            ]);
        }

        return response()->json(['message' => 'Form fields created successfully', 'fields' => $formFields]);
    }
}