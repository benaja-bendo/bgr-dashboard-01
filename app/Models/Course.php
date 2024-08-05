<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stateCourse()
    {
        return $this->belongsTo(StateCourse::class, 'states_courses_id');
    }
}
