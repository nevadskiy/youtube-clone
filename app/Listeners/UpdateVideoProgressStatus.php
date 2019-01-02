<?php

namespace App\Listeners;

use App\Events\EncodeProgressChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateVideoProgressStatus
{
    /**
     * Handle the event.
     *
     * @param  EncodeProgressChanged  $event
     * @return void
     */
    public function handle(EncodeProgressChanged $event)
    {
        $event->video->progress((int) $event->percentage);
    }
}
