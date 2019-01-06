<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVoteRequest;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoVoteController extends Controller
{
    public function show(Request $request, Video $video)
    {
        $response = [
            'up' => null,
            'down' => null,
            'can_vote' => $video->isVotesAllowed(),
            'user_vote' => null,
        ];

        if ($video->isVotesAllowed()) {
            $response['up'] = $video->upVotes()->count();
            $response['down'] = $video->downVotes()->count();
        }

        if ($request->user()) {
            $voteFromUser = $video->voteFromUser($request->user())->first();
            $response['user_vote'] = $voteFromUser ? $voteFromUser->type : null;
        }

        return response()->json($response, Response::HTTP_OK);
    }

    public function store(CreateVoteRequest $request, Video $video)
    {
        $this->authorize('vote', $video);

        $video->voteFromUser($request->user())->delete();

        $video->votes()->create([
            'type' => $request->type,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([], Response::HTTP_CREATED);
    }

    public function destroy(Request $request, Video $video)
    {
        $this->authorize('vote', $video);

        $video->voteFromUser($request->user())->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
