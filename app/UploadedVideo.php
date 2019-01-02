<?php

namespace App;

use Illuminate\Support\Facades\Storage;

class UploadedVideo
{
    /**
     * @var string
     */
    private $filename;

    public function __construct(string $filename)
    {
        // TODO: rewrite to use with no name conflicts
        // generate new hash name with extension and use separate field for original name
        // use date directories for storing bucket files

        $this->filename = $filename;
    }

    public function saveTempFile($file)
    {
        return $file->storeAs($this->getTempFileLocation(), $this->filename, 'local');
    }

    public function getTempFilePath()
    {
        return Storage::disk('local')->path("{$this->getTempFileLocation()}/{$this->filename}");
    }

    public function getTempFileLocation()
    {
        return '/uploads/videos/';
    }

    public function upload()
    {
        Storage::disk('s3')->putFileAs('videos', new File($this->getTempFilePath()), $this->filename);
    }

    public function removeTempFile()
    {
        Storage::disk('local')->delete("{$this->getTempLocation()}/{$this->filename}");
    }
}
