<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachingCourse extends Model
{
    use HasFactory;
    protected $fillable = [
        'professor_id',
        'course_id',
        'department_id',
    ];

    public function professor () {
        return $this->belongsTo(Professors::class);
    }
    public function course () {
        return $this->belongsTo(Course::class);
    }
    public function department () {
        return $this->belongsTo(Department::class);
    }
}
