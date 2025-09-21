<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiKey extends Model
{
    protected $fillable = ['user_id', 'type', 'key'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
