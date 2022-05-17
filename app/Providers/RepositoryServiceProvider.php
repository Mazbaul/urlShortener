<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UrlShortenerInterface;
use App\Repositories\UrlShortenerRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->bind(UrlShortenerInterface::class, UrlShortenerRepository::class);    
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
