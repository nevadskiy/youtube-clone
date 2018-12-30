<?php

namespace App\Jobs;

use App\Models\Channel;
use Closure;
use Illuminate\Bus\Queueable;
use Illuminate\Http\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Channel
     */
    private $channel;

    /**
     * @var
     */
    private $filename;

    /**
     * Create a new job instance.
     *
     * @param Channel $channel
     * @param $filename
     */
    public function __construct(Channel $channel, $filename)
    {
        $this->channel = $channel;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = $this->onTempFile(function ($path) {
            return Storage::disk('s3')->put('profile', new File($path));
        });

        $this->channel->image = $path;
        $this->channel->save();
    }

    private function onTempFile(Closure $callback)
    {
        // Get real path of temp file
        $tempFilePath = Storage::disk('local')->path($this->filename);

        // Run callback with path
        $result = $callback($tempFilePath);

        // Remove temp file
        Storage::disk('local')->delete($this->filename);

        // Return callback result
        return $result;
    }
}
