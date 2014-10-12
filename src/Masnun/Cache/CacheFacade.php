<?php namespace Masnun\Cache;

use Illuminate\Support\Facades\Facade;

class CacheFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'masnun_cache';
    }

}