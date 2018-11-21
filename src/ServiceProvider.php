<?php

namespace Expnull\Ocr;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Ocr::class, function(){
            return new Ocr(config('services.ocr.key'), config('services.ocr.secret'));
        });

        $this->app->alias(Ocr::class, 'ocr');
    }

    public function provides()
    {
        return [Ocr::class, 'ocr'];
    }
}