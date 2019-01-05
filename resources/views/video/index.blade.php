@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Videos</div>

                <div class="card-body">
                    @forelse ($videos as $video)
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <a href="{{ route('videos.show', $video) }}">
                                            <img src="{{ $video->thumbnailUrl  }}" alt="{{ $video->title }} thumbnail" class="img-thumbnail">
                                        </a>
                                    </div>
                                    <div class="col-9">
                                        <a href="{{ route('videos.show', $video) }}">{{ $video->title }}</a>

                                        <div class="row">
                                            <div class="col-6">
                                                <p class="text-muted">
                                                    @if (!$video->isProcessed())
                                                        Processing ({{ $video->processed_percentage ? $video->processed_percentage . '%' : 'Starting up' }})
                                                    @else
                                                        {{ $video->created_at->diffForHumans() }}
                                                    @endif
                                                </p>

                                                <div class="d-flex">
                                                    <a href="{{ route('videos.edit', $video) }}" class="btn btn-sm btn-primary mr-2">Edit</a>

                                                    <form action="{{ route('videos.destroy', $video) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </div>
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
