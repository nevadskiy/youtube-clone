<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class UploadVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    private $filename;

    /**
     * Create a new job instance.
     *
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $this->uploadVideo($this->getTempVideoPath());

        $this->removeTempVideo();
    }

    /**
     * @param $filename
     * @return bool
     * @throws \Exception
     */
    protected function uploadVideo($filename)
    {
        $path = Storage::disk('s3')->putFileAs('videos', new File($filename), $this->filename);

        if (!$path) {
            throw new \Exception('File not uploaded');
        }

        return $path;
    }

    /**
     * @return mixed
     */
    protected function getTempVideoPath()
    {
        return Storage::disk('local')->path($this->getTempFileLocation());
    }

    /**
     * Remove temp video file
     */
    private function removeTempVideo()
    {
        Storage::disk('local')->delete($this->getTempFileLocation());
    }

    /**
     * @return string
     */
    private function getTempFileLocation(): string
    {
        return "uploads/videos/{$this->filename}";
    }
}
