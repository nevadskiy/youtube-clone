@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @if ($video->isPrivate() && Auth::check() && $video->isOwnedByUser(Auth::user()))
                <div class="alert alert-info" role="alert">
                    Your video is currently private. You you can see it.
                </div>
            @endif

            @if ($video->isProcessed() && $video->canBeAccessed(Auth::user()))
                Show video player
            @endif

            @if (!$video->isProcessed())
                <div class="video-placeholder">
                    <div class="video-placeholder__header">The video is processing. Come back a bit later.</div>
                </div>
            @elseif (!$video->canBeAccessed(Auth::user()))
                <div class="video-placeholder">
                    <div class="video-placeholder__header">The video is private.</div>
                </div>
            @endif

            <div class="card mb-2">
                <div class="card-body">
                    <div class="d-flex mb-2">
                        <h4 class="mb-0">{{ $video->title }}</h4>
                        <div class="ml-auto">views</div>
                    </div>
                    <div class="media">
                        <a href="{{ route('channels.show', $video->channel) }}">
                            <img width="50" height="50" class="mr-3" src="{{ $video->channel->getImage() }}" alt="{{ $video->channel->name }} image">
                        </a>

                        <div class="media-body">
                        </div>
                    </div>
                </div>
            </div>

            @if ($video->description)
                <div class="card mb-2">
                    <div class="card-body">{!! nl2br(e($video->description)) !!}</div>
                </div>
            @endif

            @if ($video->isCommentsAllowed())
                <div class="card mb-2">
                    <div class="card-body">
                        comments
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
