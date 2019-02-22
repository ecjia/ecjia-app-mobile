<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-22
 * Time: 13:28
 */

namespace Ecjia\App\Mobile\Meta;


use Ecjia\App\Mobile\ApplicationConfig;

class ConfigPush extends ApplicationConfig
{

    protected $name = 'config_push';

    protected $label;

    protected $link;

    protected $clients = [
        'iphone',
        'android'
    ];

    protected $platform;

    public function __construct($platform)
    {
        $this->platform = $platform;

        $this->label = __('推送配置', 'mobile');
    }





}