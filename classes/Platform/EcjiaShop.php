<?php

namespace Ecjia\App\Mobile\Platform;

use Ecjia\App\Mobile\ApplicationPlatform;

class EcjiaShop extends ApplicationPlatform
{
    
    
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'ecjia-shop';
    
    /**
     * 名称
     * @var string
     */
    protected $name = 'ECJia到家门店';
    
    /**
     * 描述
     * @var string
     */
    protected $description = 'ECJia到家门店App是一款以附近门店为中心的消费者购物客户端。';
    
    /**
     * 图标
     * @var string
     */
    protected $icon = '';
    
    /**
     * 支持的客户端类型
     * @var array
     */
    protected $clients = [
        [
        	'device_client' => 'iphone',
            'device_name' => 'iPhone',
            'device_code' => '6012',
        ],
        [
            'device_client' => 'android',
            'device_name' => 'Android',
            'device_code' => '6011',
        ]
    ];
    
    
    public function __construct()
    {
        
    }
    
    
    
    
    
}