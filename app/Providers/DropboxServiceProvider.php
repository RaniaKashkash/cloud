<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;

class DropboxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
{
    $this->app->bind('dropbox', function () {
        return new Filesystem(new DropboxAdapter(new DropboxClient(
            config('filesystems.disks.dropbox.token')
        )));
    });
}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
