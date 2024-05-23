<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordingMterials extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'professor_id',
        'course_id',
    ];

    public function student () {
        return $this->belongsTo(Student::class);
    }
    public function professor () {
        return $this->belongsTo(Professors::class);
    }
    public function course () {
        return $this->belongsTo(Course::class);
    }

}
