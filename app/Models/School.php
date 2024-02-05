<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'name',
        'slug',
        'email',
        'phone',
        'website',
        'level_min',
        'level_max',
        'small_description',
        'long_description',
        'status',
        'logo',
        'cover',
    ];

    /**
     * Get the tenant associated with the school.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
