<?php

// app/Models/Nurse.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nurse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nurse_number',
        'license_number',
        'shift',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}