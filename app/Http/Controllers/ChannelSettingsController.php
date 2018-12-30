<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChannelUpdateRequest;
use App\Jobs\UploadImage;
use App\Models\Channel;
use Illuminate\Support\Facades\Storage;

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

        if ($request->file('image')) {
            // $path = $request->file('image')->store('uploads', 'local');
            $filename = Storage::disk('local')->putFile('uploads', $request->file('image'));

            // dispatch jog
            $this->dispatch(new UploadImage($channel, $filename));
        }

        // $image->

        return redirect()->route('channels.edit', $channel);
    }
}
