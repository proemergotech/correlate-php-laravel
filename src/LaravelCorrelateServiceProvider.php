<?php

namespace ProEmergotech\Correlate\Laravel;

use Illuminate\Support\ServiceProvider;

class LaravelCorrelateServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->middleware([
            LaravelCorrelateMiddleware::class,
        ]);
    }
}

