## Cache

A laravel package that allows using two caching engines, one as a fallback for the other

### Installation

Add the following to your `composer.json` file's `require` section:

```json
	"masnun/cache": "dev-master"
```

Run `composer update`. Composer should install the latest version of the package. 

Now, register the Service Provider in `app/config/app.php` file. Add the following line to the `providers` array: 

```
'Masnun\Cache\CacheServiceProvider'
```

You should next register an `alias` for the API. We recommend `MCache`. Add the following line to the `aliases` array in the same file:

```
'MCache'  => 'Masnun\Cache\CacheFacade',
```

Let's publish the configuration values for the package. Execute from the command line:

```
php artisan config:publish masnun/cache
```

The configuration file will be published to `app/config/packages/masnun/cache/cache.php`. Please feel free to tweak the values. Here's a short description: 

* `primary` - the name of the primary cache driver (eg. 'memcached' for memcached )
* `secondary` - the name of the fallback cache driver
* `default_expiration` - the default value for cache expiration
* `async` - should the data be offloaded using background async queues?
* `async_driver` - if yes, then using which queue driver? 

(PS: The async data offloading still not implemented, it's work in progress). 

### Code Sample

```php
Route::get('/', function ()
{
    MCache::put('name', 'masnun', 60);
    return MCache::get('name');
});
```
Please feel free to be creative and try the usual `Cache` APIs. Here's a list of currently implemented methods: 

* put()
* add()
* has()
* get()
* forever()
* remember()
* rememberForever()
* pull()
* forget()