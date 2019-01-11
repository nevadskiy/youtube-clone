<?php

namespace App\Policies;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChannelPolicy
{
    use HandlesAuthorization;

    /***
     * @param User $user
     * @param Channel $channel
     * @return bool
     */
    public function update(User $user, Channel $channel): bool
    {
        return $user->id === $channel->user_id;
    }

    /***
     * @param User $user
     * @param Channel $channel
     * @return bool
     */
    public function subscribe(User $user, Channel $channel): bool
    {
        return !$user->ownsChannel($channel);
    }

    /***
     * @param User $user
     * @param Channel $channel
     * @return bool
     */
    public function unsubscribe(User $user, Channel $channel): bool
    {
        return !$user->isSubscribedTo($channel);
    }
}
