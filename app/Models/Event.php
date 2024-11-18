<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

     protected $fillable = ['organization_id', 'name', 'description', 'image_path'];

    // Relasi: Satu event memiliki banyak form field
    public function formFields()
    {
        return $this->hasMany(FormField::class);
    }

    // Relasi: Event terkait dengan satu organisasi
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}