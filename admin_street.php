<?php

defined('IN_ECJIA') or exit('No permission resources.');


class admin_street extends ecjia_admin
{
    
    public function __construct()
    {
        parent::__construct();
        
        
    }
    
    
    public function init()
    {
        
        ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('店铺街APP')));
   
        
        
        
        
        $this->display('mobile_street.dwt');
    }
}

// end