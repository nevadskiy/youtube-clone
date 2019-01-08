<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Comment $resource
 */
class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'body' => $this->resource->body,
            'created_at' => $this->resource->created_at->toDateTimeString(),
            'created_at_humans' => $this->resource->created_at->diffForHumans(),
            'channel' => new ChannelResource($this->whenLoaded('user', function () {
                return $this->resource->user->channel->first();
            })),
            'replies' => self::collection($this->whenLoaded('replies', function () {
                return $this->resource->replies;
            }))
        ];
    }
}
