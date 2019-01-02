<?php

namespace App\Listeners;

use App\Events\VideoProcessed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateProcessedStatus
{
    /**
     * Handle the event.
     *
     * @param  VideoProcessed  $event
     * @return void
     */
    public function handle(VideoProcessed $event)
    {
        $event->video->processed();
    }
}
