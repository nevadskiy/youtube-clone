<?php

namespace App\Events;

use App\Models\Video;
use Illuminate\Queue\SerializesModels;

class EncodeProgressChanged
{
    use SerializesModels;

    /**
     * @var Video
     */
    public $video;

    /**
     * @var int
     */
    public $percentage;

    /**
     * Create a new event instance.
     *
     * @param Video $video
     * @param int $percentage
     */
    public function __construct(Video $video, int $percentage)
    {
        $this->video = $video;
        $this->percentage = $percentage;
    }
}
