<?php

namespace App;

use Illuminate\Support\Facades\Storage;

class UploadedFile
{
    public function getTempLocation()
    {
        return Storage::disk('local')->
    }
}