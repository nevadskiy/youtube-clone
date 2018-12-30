@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Channel settings</div>

                    <div class="card-body">
                        <form action="{{ route('channels.update', $channel) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name" class="col-form-label">{{ __('Name') }}</label>

                                <input id="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                       value="{{ old('name', $channel->name) }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="slug" class="col-form-label">{{ __('Slug') }}</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">{{ url('/') }}/channel/</div>
                                    </div>
                                    <input id="slug" type="text" name="slug"
                                           class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                                           value="{{ old('slug', $channel->slug) }}" required autofocus>
                                    @if ($errors->has('slug'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('slug') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-form-label">{{ __('Description') }}</label>

                                <textarea
                                        id="description"
                                        name="description"
                                        class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                >{{ old('description', $channel->description) }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="image" class="col-form-label">{{ __('Channel image') }}</label>

                                <input type="file" name="image" id="image">

                                {{--@if ($errors->has('image'))--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $errors->first('image') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
