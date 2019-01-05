@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit video "{{ $video->title }}"</div>

                <div class="card-body">
                    <form action="{{ route('videos.update', $video) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title" class="col-form-label">{{ __('Title') }}</label>

                            <input
                                    id="title"
                                    type="text"
                                    name="title"
                                    class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                    value="{{ old('title', $video->title) }}"
                                    required
                            >

                            @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-form-label">{{ __('Description') }}</label>

                            <textarea
                                    id="description"
                                    name="description"
                                    class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                            >{{ old('description', $video->description) }}</textarea>

                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="visibility" class="col-form-label">{{ __('Visibility') }}</label>

                            <select
                                    id="visibility"
                                    name="visibility"
                                    class="form-control{{ $errors->has('visibility') ? ' is-invalid' : '' }}"
                            >
                                @foreach (['public', 'unlisted', 'private'] as $visibility)
                                    <option value="{{ $visibility }}"{{ $video->visibility === $visibility ? ' selected' : '' }}>{{ ucfirst($visibility) }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('visibility'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('visibility') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="allow_votes" class="col-form-label">
                                <input type="checkbox" name="allow_votes" id="allow_votes"{{ $video->isVotesAllowed() ? ' checked' : '' }}> {{ __('Allow votes') }}
                            </label>

                            @if ($errors->has('allow_votes'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('allow_votes') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="allow_comments" class="col-form-label">
                                <input type="checkbox" name="allow_comments" id="allow_comments"{{ $video->isCommentsAllowed() ? ' checked' : '' }}> {{ __('Allow comments') }}
                            </label>

                            @if ($errors->has('allow_comments'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('allow_comments') }}</strong>
                                </span>
                            @endif
                        </div>

                        <button class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
