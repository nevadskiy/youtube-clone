<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VideoView extends Model
{
    protected $fillable = [
        'user_id',
        'ip',
    ];

    public function scopeByUser(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeLatestByUser(Builder $query, User $user)
    {
        return $query->byUser($user)->orderByDesc('created_at')->limit(1);
    }

    public function scopeLatestByIp(Builder $query, string $ip)
    {
        return $query->where('ip', $ip)->orderByDesc('created_at')->limit(1);
    }
}
