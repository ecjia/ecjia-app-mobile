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
    
            $dir = __DIR__ . '/Platform';
    
            $platforms = royalcms('files')->files($dir);

            $factories = [];
    
            foreach ($platforms as $key => $value) {
                $value = str_replace($dir . '/', '', $value);
                $value = str_replace('.php', '', $value);
                $className = __NAMESPACE__ . '\Platform\\' . $value;
                
                $class = new $className;
                $code = $class->getCode();
                $name = $class->getName();
                $desciption = $class->getDescription();
                $factories[$code] = [
                	'code' => $code,
                    'name' => $name,
                    'description' => $desciption,
                    'class' => $className,
                ];
            }
    
            RC_Cache::app_cache_set($cache_key, $factories, 'mobile', 10080);
        }
    
        return RC_Hook::apply_filters('ecjia_mobile_application_platform_filter', $factories);
    }
    
    
    public function getPlatforms()
    {
        $platforms = [];
    
        foreach (self::$factories as $value) {
            $platform = new $value;
            $key = $platform->getCode();
            $platforms[$key] = $platform;
        }
    
        return $platforms;
    }
    
    
    public function platform($code)
    {
        if (!array_key_exists($code, self::$factories)) {
            throw new InvalidArgumentException("Application platform '$code' is not supported.");
        }
    
        $platform = self::$factories[$code];
        $className = $platform['class'];
    
        return new $className();
    }
    
    
}
