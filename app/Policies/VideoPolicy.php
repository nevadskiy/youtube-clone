<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Video;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Video $video
     * @return bool
     */
    public function update(User $user, Video $video): bool
    {
        return $user->id === $video->channel->user_id;
    }

    /**
     * @param User $user
     * @param Video $video
     * @return bool
     */
    public function edit(User $user, Video $video): bool
    {
        return $user->id === $video->channel->user_id;
    }

    /**
     * @param User $user
     * @param Video $video
     * @return bool
     */
    public function delete(User $user, Video $video): bool
    {
        return $user->id === $video->channel->user_id;
    }

    /**
     * @param User $user
     * @param Video $video
     * @return bool
     */
    public function vote(User $user, Video $video): bool
    {
        if (!$video->canBeAccessed($user)) {
            return false;
        }

        if (!$video->isVotesAllowed()) {
            return false;
        }

        return true;
    }

    public function comment(User $user, Video $video)
    {
        if (!$video->canBeAccessed($user)) {
            return false;
        }

        if (!$video->isCommentsAllowed()) {
            return false;
        }

        return true;
    }
}
