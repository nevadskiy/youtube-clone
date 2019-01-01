<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoUpdateRequest;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        $uid = uniqid(true);

        $channel = $request->user()->channel()->first();

        $video = $channel->videos()->create([
            'uid' => $uid,
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'visibility' => $request->get('visibility'),
            'video_filename' => "{$uid}.{$request->get('extension')}",
        ]);

        return response()->json([
            'data' => [
                'uid' => $uid,
            ],
        ]);
    }

    public function update(VideoUpdateRequest $request, Video $video)
    {
        $this->authorize('update', $video);

        $video->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'visibility' => $request->get('visibility'),
            'allow_votes' => $request->has('allow_votes'),
            'allow_comments' => $request->has('allow_comments'),
        ]);

        if ($request->expectsJson()) {
            return $this->successJson();
        }

        return redirect()->back();
    }
}
