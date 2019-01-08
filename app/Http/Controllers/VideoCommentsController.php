<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Video;

class VideoCommentsController extends Controller
{
    public function index(Video $video)
    {
        return response()->json(
            CommentResource::collection(
                $this->getVideoCommentsWithRelations($video)
            )
        );
    }

    /**
     * @param Video $video
     * @return Video[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getVideoCommentsWithRelations(Video $video)
    {
        return $video->comments()->latest()->with(['user.channel', 'replies.user.channel'])->get();
    }
}
