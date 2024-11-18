<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'type', 'label', 'required','options'];

    // Relasi: Field terkait dengan satu event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}