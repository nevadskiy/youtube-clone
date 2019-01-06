<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoViewController extends Controller
{
    const BUFFER = 30;

    public function store(Request $request, Video $video)
    {
        // Check if video can be accessed
        if (!$video->canBeAccessed($request->user())) {
            return response()->json([], Response::HTTP_FORBIDDEN);
        }

        // Check buffer for user from latest view
        if ($request->user()) {
            $lastUserView = $video->views()->latestByUser($request->user())->first();

            if ($this->withinBuffer($lastUserView)) {
                return response()->json([], Response::HTTP_NO_CONTENT);
            }
        }

        // Check buffer for IP from latest view
        $lastIpView = $video->views()->latestByIp($request->ip())->first();

        if ($this->withinBuffer($lastIpView)) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        // Create view
        $video->views()->create([
            'user_id' => $request->user() ? $request->user()->id : null,
            'ip' => $request->ip(),
        ]);

        return response()->json([], Response::HTTP_OK);
    }

    private function withinBuffer(?VideoView $view)
    {
        return $view && $view->created_at->diffInSeconds(Carbon::now()) < self::BUFFER;
    }
}
