<?php

namespace App\Services;

use App\Encoders\VideoEncoder;
use App\Events\EncodeProgressChanged;
use App\Events\VideoProcessed;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

class VideoProcessService
{
    /**
     * @var VideoEncoder
     */
    private $encoder;

    /**
     * VideoProcessService constructor.
     * @param VideoEncoder $encoder
     */
    public function __construct(VideoEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param Video $video
     * @param string $originalPath
     * @param string $encodePath
     */
    public function process(Video $video, string $originalPath, string $encodePath)
    {
        $this->encoder->onProgress(function ($percentage) use ($video) {
            event(new EncodeProgressChanged($video, $percentage));
        });

        $this->encoder->onFinish(function () use ($video, $originalPath) {
            event(new VideoProcessed($video));
        });

        $this->encoder->encode($originalPath, $encodePath);
    }
}