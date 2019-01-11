@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $channel->name }}</div>

                <div class="card-body">
                    @foreach ($videos as $video)
                        <h3><a href="{{ route('videos.show', $video) }}">{{ $video->title }}</a></h3>
                    @endforeach

                    {{ $videos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
