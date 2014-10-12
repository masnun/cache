<?php namespace Masnun\Cache;

class CacheManager
{


    public function __construct($app)
    {
        $this->cache = $app['cache'];
        $this->primaryCache = $this->cache
            ->driver(\Config::get('masnun_cache::cache.primary'));

        $this->secondaryCache = $this->cache
            ->driver(\Config::get('masnun_cache::cache.secondary'));

        $this->asyncPersistence = \Config::get('masnun_cache::cache.async');
        $this->defaultExpiration = \Config::get('masnun_cache::cache.default_expiration');

        if ($this->asyncPersistence)
        {
            $this->asyncDriver = \Config::get('masnun_cache::cache.async_driver');
        }

    }

    public function put($key, $value, $time)
    {
        $this->secondaryCache->put($key, $value, $time);
        return $this->primaryCache->put($key, $value, $time);
    }

    public function add($key, $value, $time)
    {
        $this->secondaryCache->put($key, $value, $time);
        return $this->primaryCache->put($key, $value, $time);
    }

    public function has($key)
    {
        if (!$this->primaryCache->has($key))
        {
            return $this->secondaryCache->has($key);
        }
        else
        {
            return true;
        }
    }

    public function get($key, $default = null)
    {
        if ($this->primaryCache->has($key))
        {
            var_dump('pri');
            return $this->primaryCache->get($key);
        }
        else
        {
            if ($this->secondaryCache->has($key))
            {
                $value = $this->secondaryCache->get($key);
                $this->primaryCache->put($key, $value, $this->defaultExpiration);
                return $value;
            }
            else
            {
                if (is_object($default) && $default instanceof \Closure)
                {
                    return $default();
                }
                else
                {
                    return $default;
                }
            }
        }
    }

    public function forever($key, $value)
    {
        $this->secondaryCache->forever($key, $value);
        return $this->primaryCache->forever($key, $value);
    }

    public function remember($key, $time, $closure)
    {
        $this->secondaryCache->remember($key, $time, $closure);
        return $this->primaryCache->remember($key, $time, $closure);
    }

    public function rememberForever($key, $closure)
    {
        $this->secondaryCache->rememberForever($key, $closure);
        return $this->primaryCache->rememberForever($key, $closure);
    }

    public function pull($key)
    {
        $this->secondaryCache->pull($key);
        return $this->primaryCache->pull($key);
    }

    public function forget($key)
    {
        $this->secondaryCache->forget($key);
        return $this->primaryCache->forget($key);
    }


}
