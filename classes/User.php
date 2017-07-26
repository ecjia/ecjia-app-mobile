<?php

namespace Ecjia\App\Mobile;

use Ecjia\App\Mobile\Models\MobileDeviceModel;

class User {
    
    const TYPE_USER      = 'user';
    const TYPE_ADMIN     = 'admin';
    const TYPE_MERCHANT  = 'merchant';
    
    protected $user_id;
    
    protected $user_type;
    
    
    public function __construct($user_type, $user_id)
    {
        $this->user_type = $user_type;
        $this->user_id = $user_id;
    }
    
    
    public function getUserType()
    {
        return $this->user_type;
    }
    
    
    public function getUserId()
    {
        return $this->user_id;
    }
    
    
    public function getDevices()
    {
        $model = new MobileDeviceModel();
        
        switch ($this->user_type) {
        
    	    case self::TYPE_USER:
    	       $model->user();
    	       break;
    	       
    	    case self::TYPE_ADMIN:
    	        $model->admin();
    	        break;
    	        
    	    case self::TYPE_MERCHANT:
    	        $model->merchant();
    	        break;
    	       
            default:
        }
        
        $model->whereNotNull('device_token');
        return $model->get();
    }
    
    
    
    
}