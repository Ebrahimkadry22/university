<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityCity extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'room_id',
        'bed_id',
        'status',
    ];

    public function student () {
        return $this->belongsTo(Student::class);
    }
    public function room () {
        return $this->belongsTo(Room::class);
    }
    public function bed () {
        return $this->belongsTo(Bed::class);
    }
}
