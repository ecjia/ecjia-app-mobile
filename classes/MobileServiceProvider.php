<?php

namespace Ecjia\App\Mobile;

use Royalcms\Component\App\AppServiceProvider;

class MobileServiceProvider extends  AppServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-mobile');
    }
    
    public function register()
    {
        
    }
    
    
    
}