<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVideoCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Video;
use Illuminate\Http\Response;

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

    public function store(CreateVideoCommentRequest $request, Video $video)
    {
        $this->authorize('comment', $video);

        $comment = $video->comments()->create([
            'body' => $request->get('body'),
            'reply_id' => $request->get('reply_id', null),
            'user_id' => $request->user()->id,
        ]);

        return response()->json(
            CommentResource::make($comment->load(['user']))
        );
    }

    public function destroy(Video $video, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
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
