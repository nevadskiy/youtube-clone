<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Channel extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function getImage()
    {
        if (!$this->image) {
            return asset('img/default-avatar.jpg');
        }

        return Storage::disk('s3')->url($this->image);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscriptionCount()
    {
        return $this->subscriptions->count();
    }
}
