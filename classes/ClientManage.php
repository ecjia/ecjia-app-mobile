<?php

namespace Ecjia\App\Mobile;

use RC_Hashids;

class ClientManage
{
    
    protected static $keyPrefix = 'ecjia';
    
    /**
     * 生成App key
     */
    public static function generateAppKey() 
    {
        $key = rc_random(16, 'abcdefghijklmnopqrstuvwxyz0123456789');
        return self::$keyPrefix.$key;
    }
    
    /**
     * 生成App Secret
     */
    public static function generateAppSecret() 
    {
        $key = rc_random(16, 'abcdefghijklmnopqrstuvwxyz0123456789');
        return sha1($key);
    }
    
}