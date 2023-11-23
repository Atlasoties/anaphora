<?php
namespace Jacktech\Anaphora;

use Illuminate\Support\ServiceProvider;
use Jacktech\Anaphora\Anaphora;

class AnaphoraServiceProvider extends ServiceProvider
{
    public function register()
    {
       $this->app->bind('anaphora', function () {
            return new Anaphora();
        });
    }

    public function boot()
    {
        // Publish configuration file
        $this->publishes([
            __DIR__.'/../config/anaphora.php' => config_path('anaphora.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'migrations');
        }
    }
}