<?php

namespace App\Events;

use App\Models\Video;
use Illuminate\Queue\SerializesModels;

class VideoProcessed
{
    use SerializesModels;

    /**
     * @var Video
     */
    public $video;

    /**
     * Create a new event instance.
     *
     * @param Video $video
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }
}
