<?php

namespace App\Jobs;

use App\Models\Video;
use App\Services\VideoProcessService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ProcessVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Video
     */
    private $video;

    /**
     * Create a new job instance.
     *
     * @param Video $video
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @param VideoProcessService $service
     * @return void
     */
    public function handle(VideoProcessService $service)
    {
        $originalVideoPath = Storage::disk('local')->path($this->getOriginalLocation());

        $encodeVideoPath = Storage::disk('local')->path($this->getEncodeLocation());

        $service->process($this->video, $originalVideoPath, $encodeVideoPath);

        $this->removeOriginalVideo();

        $this->uploadEncodedVideo($encodeVideoPath);

        $this->removeEncodedVideo();
    }

    /**
     * Remove original local video
     */
    private function removeOriginalVideo()
    {
        Storage::disk('local')->delete($this->getOriginalLocation());
    }

    /**
     * @param $encodeVideoPath
     */
    private function uploadEncodedVideo($encodeVideoPath): void
    {
        Storage::disk('s3')->putFileAs('videos', new File($encodeVideoPath), $this->video->video_filename);
    }

    /**
     * Remove encoded local video
     */
    private function removeEncodedVideo(): void
    {
        Storage::disk('local')->delete($this->getEncodeLocation());
    }

    /**
     * @return string
     */
    private function getOriginalLocation(): string
    {
        return "uploads/videos/{$this->video->video_filename}";
    }

    /**
     * @return string
     */
    private function getEncodeLocation(): string
    {
        return "processed/{$this->video->video_filename}";
    }
}
