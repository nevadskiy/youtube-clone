<?php

namespace App\Providers;

use App\Encoders\FFmpegVideoEncoder;
use App\Encoders\VideoEncoder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(VideoEncoder::class, function () {
            return new FFmpegVideoEncoder(resolve('log'));
        });
    }
}
