<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChannelUpdateRequest;
use App\Models\Channel;

class ChannelSettingsController extends Controller
{
    public function edit(Channel $channel)
    {
        $this->authorize('update', $channel);

        return view('channels.settings.edit', compact('channel'));
    }

    public function update(ChannelUpdateRequest $request, Channel $channel)
    {
        $this->authorize('update', $channel);

        $channel->update([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'description' => $request->get('description'),
        ]);

        return redirect()->route('channels.edit', $channel);
    }
}
