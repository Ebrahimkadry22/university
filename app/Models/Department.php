<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id',
    ];

    public function cousres () {
        return $this->hasMany(Course::class);
    }
    public function teachingCourse () {
        return $this->hasMany(TeachingCourse::class);
    }
}
