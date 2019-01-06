@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            player


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
