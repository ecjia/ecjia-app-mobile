<?php

namespace Ecjia\App\Mobile;

use Royalcms\Component\App\AppParentServiceProvider;

class MobileServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-mobile', null, dirname(__DIR__));
    }
    
    public function register()
    {
        
    }
    
    
    
}