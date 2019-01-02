<?php

namespace App\Encoders;

use Closure;

interface VideoEncoder
{
    public function encode($originalPath, $encodePath);

    public function onProgress(Closure $callback);

    public function onFinish(Closure $callback);
}