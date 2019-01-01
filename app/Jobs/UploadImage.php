<?php

namespace App\Jobs;

use App\Models\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Http\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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
        $tempFilePath = $this->getTempImagePath();

        $this->resizeImage($tempFilePath);

        $path = $this->uploadImage($tempFilePath);

        info($path);

        $this->removeTempImage();

        $this->updateChannelImage($path);
    }

    /**
     * Get real path of temp file
     *
     * @return string
     */
    protected function getTempImagePath()
    {
        return Storage::disk('local')->path($this->filename);
    }

    /**
     * Resize image
     *
     * @param $tempFilePath
     */
    protected function resizeImage($tempFilePath): void
    {
        Image::make($tempFilePath)
            ->encode('png')
            ->fit(40, 40, function ($c) {
                $c->upsize();
            })
            ->save();
    }

    /**
     * Upload to s3
     *
     * @param $tempFilePath
     * @return string|bool
     */
    protected function uploadImage($tempFilePath)
    {
        return Storage::disk('s3')->put('profile', new File($tempFilePath));
    }

    /**
     * Remove temp file
     */
    protected function removeTempImage(): void
    {
        Storage::disk('local')->delete($this->filename);
    }

    /**
     * Update channel image url
     *
     * @param bool $path
     */
    protected function updateChannelImage(bool $path): void
    {
        $this->channel->image = $path;
        $this->channel->save();
    }
}
