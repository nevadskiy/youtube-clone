<?php

namespace App\Encoders;

use Closure;
use FFMpeg\Format\Video\X264;
use Psr\Log\LoggerInterface;

class FFmpegVideoEncoder implements VideoEncoder
{
    private $ffmpeg;
    private $onProgressCallback;
    private $onFinishCallback;

    public function __construct(LoggerInterface $logger, $parameters = [])
    {
        $this->ffmpeg = \FFMpeg\FFMpeg::create($parameters, $logger);
    }
    
    public function encode($originalPath, $encodePath)
    {
        $file = $this->ffmpeg->open($originalPath);

        $format = $this->setUpFormat();

        if ($this->onProgressCallback) {
            $format->on('progress', function ($video, $format, $percentage) {
                call_user_func($this->onProgressCallback, $percentage);
            });
        }

        $file->save($format, $encodePath);

        if ($this->onFinishCallback) {
            call_user_func($this->onFinishCallback);
        }
    }

    public function onProgress(Closure $callback)
    {
        $this->onProgressCallback = $callback;
    }

    public function onFinish(Closure $callback)
    {
        $this->onFinishCallback = $callback;
    }

    /**
     * @return X264
     */
    private function setUpFormat()
    {
        $format = new X264();

        $format->setAudioCodec('libmp3lame');

        return $format;
    }
}