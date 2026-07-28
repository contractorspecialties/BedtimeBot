<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'age',
    ];

    /**
     * Get the parent that owns the child profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}