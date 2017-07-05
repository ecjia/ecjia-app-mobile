<?php

namespace Ecjia\App\Mobile\Platform;

use Ecjia\App\Mobile\ApplicationPlatform;

class EcjiaWeapp extends ApplicationPlatform
{
    
    
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'ecjia-shop-weapp';
    
    /**
     * 名称
     * @var string
     */
    protected $name = 'ECJia到家门店小程序';
    
    /**
     * 描述
     * @var string
     */
    protected $description = 'ECJia到家门店小程序是一款以附近门店为中心的消费者购物微信小程序。';
    
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
        'weapp',
    ];
    
    
    public function __construct()
    {
        
    }
    
    
    
    
    
}