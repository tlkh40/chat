<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $user_id
 * @property string $contents
 * @property int $channel_id
 * @property \App\Models\Channel $channel
 * @property \App\Models\User $user
 */
class Message extends Model {
    protected $fillable = [
        'user_id',
        'contents',
        'channel_id',
    ];

    public function channel(): HasOne
    {
        return $this->hasOne(Channel::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
