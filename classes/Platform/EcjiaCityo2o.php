<?php

namespace Ecjia\App\Mobile\Platform;

use Ecjia\App\Mobile\ApplicationPlatform;

class EcjiaCityo2o extends ApplicationPlatform
{
    
    
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'ecjia-cityo2o';
    
    /**
     * 名称
     * @var string
     */
    protected $name = 'ECJia到家';
    
    /**
     * 描述
     * @var string
     */
    protected $description = 'ECJia到家App是一款集消费者、商家、配送员于一体的客户端。';
    
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
        	'device-client' => 'iphone',
            'device-name' => 'iPhone',
            'device-code' => '6002',
        ],
        [
            'device-client' => 'android',
            'device-name' => 'Android',
            'device-code' => '6001',
        ]
    ];
    
    
    public function __construct()
    {
        
    }
    
    
    
    
    
}