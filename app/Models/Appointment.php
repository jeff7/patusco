<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'email',
        'animal_name',
        'animal_type',
        'age',
        'symptoms',
        'appointment_date',
        'period',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
