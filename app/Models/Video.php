<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
