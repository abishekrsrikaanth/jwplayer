<?php

namespace App\JwPlayer;

use App\JwPlayer\Commands\JwPlayerCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class JwPlayerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('jwplayer')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(JwPlayerCommand::class);
    }

    public function registeringPackage()
    {
        $this->app->bind('jwplayer', function ($app) {
            return new JwPlayer();
        });
    }
}
