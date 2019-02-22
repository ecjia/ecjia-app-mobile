<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-22
 * Time: 13:28
 */

namespace Ecjia\App\Mobile\Meta;


use Ecjia\App\Mobile\ApplicationConfig;

class ConfigPay extends ApplicationConfig
{

    protected $name = 'config_pay';

    protected $label;

    protected $link;

    protected $clients = [
        'all',
    ];

    protected $platform;

    public function __construct($platform)
    {
        $this->platform = $platform;

        $this->label = __('支付配置', 'mobile');
    }





}