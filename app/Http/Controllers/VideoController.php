<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoUpdateRequest;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $videos = $request->user()->videos()->latest()->paginate(10);

        return view('video.index', compact('videos'));
    }

    public function edit(Video $video)
    {
        $this->authorize('edit', $video);

        return view('video.edit', compact('video'));
    }

    public function update(VideoUpdateRequest $request, Video $video)
    {
        $this->authorize('update', $video);

        $video->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'visibility' => $request->get('visibility'),
            'allow_votes' => !!$request->get('allow_votes'),
            'allow_comments' => !!$request->get('allow_comments'),
        ]);

        if ($request->expectsJson()) {
            return $this->successJson();
        }

        return redirect()->back();
    }

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

    public function destroy(Request $request, Video $video)
    {
        $this->authorize('delete', $video);

        return redirect()->back();
    }
}
