<?php namespace Masnun\Cache;

use Illuminate\Support\ServiceProvider;
use Masnun\Cache\CacheManager;

class CacheServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('masnun_cache', function ()
        {
            return new CacheManager($this->app);
        });

    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('masnun/cache', 'masnun_cache');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
