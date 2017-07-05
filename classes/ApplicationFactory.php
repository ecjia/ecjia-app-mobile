<?php

namespace Ecjia\App\Mobile;

use RC_Hook;
use RC_Cache;
use InvalidArgumentException;

class ApplicationFactory
{
    
    protected static $factories;
    
    public function __construct()
    {
        self::$factories = $this->getFactories();
    }
    
    public function getFactories()
    {
        $cache_key = 'mobile_application_factories';
    
        $factories = RC_Cache::app_cache_get($cache_key, 'mobile');
    
        if (empty($factories)) {
    
            $dir = __DIR__ . '/Events';
    
            $events = royalcms('files')->files($dir);
    
            $factories = [];
    
            foreach ($events as $key => $value) {
                $value = str_replace($dir . '/', '', $value);
                $value = str_replace('.php', '', $value);
                $className = __NAMESPACE__ . '\Platform\\' . $value;
                $key = with(new $className)->getCode();
                $factories[$key] = $className;
            }
    
            RC_Cache::app_cache_set($cache_key, $factories, 'mobile', 10080);
        }
    
        return RC_Hook::apply_filters('ecjia_mobile_application_platform_filter', $factories);
    }
    
    
    public function getPlatforms()
    {
        $events = [];
    
        foreach (self::$factories as $value) {
            $event = new $value;
            $key = $event->getCode();
            $events[$key] = $event;
        }
    
        return $events;
    }
    
    
    public function platform($code)
    {
        if (!array_key_exists($code, self::$factories)) {
            throw new InvalidArgumentException("Event '$code' is not supported.");
        }
    
        $className = self::$factories[$code];
    
        return new $className();
    }
    
    
}
