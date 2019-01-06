<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'uid',
        'video_id',
        'video_filename',
        'visibility',
        'allow_comments',
        'allow_votes',
        'processed',
        'processed_percentage',
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function getRouteKeyName()
    {
        return 'uid';
    }

    public function processed()
    {
        $this->update(['processed' => true]);
    }

    public function progress(int $percentage)
    {
        $this->update(['processed_percentage' => $percentage]);
    }

    public function isVotesAllowed(): bool
    {
        return !!$this->allow_votes;
    }

    public function isCommentsAllowed(): bool
    {
        return !!$this->allow_comments;
    }

    public function isPrivate(): bool
    {
        return $this->visibility === 'private';
    }

    public function getThumbnailUrlAttribute()
    {
        if (!$this->isProcessed()) {
            return asset('img/default-thumb.jpg');
        }

        return Storage::disk('s3')->url("videos/{$this->uid}.jpg");
    }

    public function isProcessed()
    {
        return $this->processed;
    }

    public function isOwnedByUser(User $user): bool
    {
        return $this->channel->user_id === $user->id;
    }

    public function canBeAccessed(?User $user): bool
    {
        if (!$user && $this->isPrivate()) {
            return false;
        }

        if ($user && $this->isPrivate() && !$this->isOwnedByUser($user)) {
            return false;
        }

        return true;
    }

    public function getStreamUrl(): string
    {
        return Storage::disk('s3')->url("videos/{$this->video_filename}");
    }

    public function views()
    {
        return $this->hasMany(VideoView::class);
    }

    public function viewCount()
    {
        return $this->views->count();
    }
}
