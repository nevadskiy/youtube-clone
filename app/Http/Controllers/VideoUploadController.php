<?php

namespace App\Http\Controllers;

use App\Jobs\UploadVideo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoUploadController extends Controller
{
    public function index()
    {
        return view('video.upload');
    }

    public function store(Request $request)
    {
        $channel = $request->user()->channel()->first();

        $video = $channel->videos()->where('uid', $request->get('uid'))->firstOrFail();

        $request->file('video')->storeAs('uploads/videos', $video->video_filename, 'local');

        $this->dispatch(new UploadVideo($video->video_filename));

        return $this->successJson();
    }
}
