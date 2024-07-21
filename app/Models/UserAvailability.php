<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medical_specialty_id',
        'date',
        'start_time',
        'end_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialty()
    {
        return $this->belongsTo(MedicalSpecialty::class, 'medical_specialty_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'availability_id')->orderBy('updated_at', 'desc');
    }

}
