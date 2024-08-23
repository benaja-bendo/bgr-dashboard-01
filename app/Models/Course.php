<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_premium',
        'states_courses_id',
    ];

    public function isPremium(): bool
    {
        return $this->is_premium;
    }

    public function getFormattedName(): string
    {
        return strtoupper($this->name);
    }

    public function stateCourse(): BelongsTo
    {
        return $this->belongsTo(StateCourse::class, 'states_courses_id');
    }
}
