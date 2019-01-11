<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function show(Channel $channel)
    {
        $videos = $channel->videos()->visible()->paginate(10);

        return view('channels.show', compact('channel', 'videos'));
    }
}
