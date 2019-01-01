<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoUploadController extends Controller
{
    public function index()
    {
        return view('video.upload');
    }

    public function store(Request $request)
    {
        // grab user channel
        // lookup the video
        // move to temp location
        // upload to s3 (job)
    }
}
