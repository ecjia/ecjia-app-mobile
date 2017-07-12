<?php

namespace Ecjia\App\Mobile\Platform;

use Ecjia\App\Mobile\ApplicationPlatform;

class EcjiaCityo2oH5 extends ApplicationPlatform
{
    
    
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'ecjia-cityo2o-h5';
    
    /**
     * 名称
     * @var string
     */
    protected $name = 'ECJia到家H5';
    
    /**
     * 描述
     * @var string
     */
    protected $description = 'ECJia到家H5是一款用于微信公众号上使用的微商城。';
    
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
        	'device_client' => 'h5',
            'device_name' => 'H5',
            'device_code' => '6004',
        ],
    ];
        
    /**
     * 支持的支付方式
     * @var array
     */
    protected $payments = [
        'pay_balance',
        'pay_cod',
        'pay_alipay',
        'pay_wxpay',
    ];
    
    
    public function __construct()
    {
        
    }
    
    
    
    
    
}