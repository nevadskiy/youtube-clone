@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Video</div>

                <div class="card-body">
                    @forelse ($videos as $video)
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <img src="{{ $video->thumbnailUrl  }}" alt="Video preview" class="img-thumbnail">
                                    </div>
                                    <div class="col-9">
                                        <div class="row">
                                            <div class="col-6">
                                                <a href="{{ route('videos.show', $video) }}">{{ $video->title }}</a>
                                            </div>
                                            <div class="col-6">
                                                {{ ucfirst($video->visibility) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>You have not videos yet.</p>
                    @endforelse

                    {{ $videos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
