<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class NumberPhone extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'type',
        'is_default',
        'country_code',
        'area_code',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
