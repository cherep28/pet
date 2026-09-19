<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefreshToken extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'token_hash',
        'access_token_id',
        'expires_at',
        'used_at',
        'revoked_at'
    ];

    protected $hidden = [
        'token_hash'
    ];

    protected function casts():array{
        return[
            'expires_at'    => 'datetime',
            'used_at'       => 'datetime',
            'revoked_at'    => 'datetime',
        ];
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
