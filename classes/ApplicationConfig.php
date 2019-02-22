<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-22
 * Time: 11:24
 */

namespace Ecjia\App\Mobile;

use Ecjia\App\Mobile\Models\MobileManageModel;
use RC_Uri;

class ApplicationConfig
{

    /**
     * @var string 配置项名字 key
     */
    protected $name;

    /**
     * @var string 配置项显示名字
     */
    protected $label;

    /**
     * @var string 配置项链接
     */
    protected $link;

    /**
     * @var array 配置项支付客户端类型
     */
    protected $clients = [];

    /**
     * @var string 配置项属于平台
     */
    protected $platform;

    /**
     * @var \Ecjia\App\Mobile\ApplicationFactory
     */
    protected static $factory;

    /**
     * @return \Ecjia\App\Mobile\ApplicationFactory
     */
    public static function getApplicationFactory()
    {
        if (is_null(self::$factory)) {
            self::$factory = new ApplicationFactory();
        }

        return self::$factory;
    }


    public static function getConfigGroups($code, $app_id)
    {

        $defaults = [

            [
                'name' => 'config_push',
                'label' => '推送配置',
                'link' => RC_Uri::url('mobile/admin_mobile_config/config_push', [
                    'code' => $code,
                    'app_id' => $app_id,
                ]),
            ],

            [
                'name' => 'config_pay',
                'label' => '支付配置',
                'link' => RC_Uri::url('mobile/admin_mobile_config/config_pay', [
                    'code' => $code,
                    'app_id' => $app_id,
                ]),
            ],

        ];

        return $defaults;
    }


    /**
     * 获取支持首页模块化的产品多客户端
     * @param $platform
     * @return array
     */
    public function getMobilePlatformClients()
    {
        $collection = MobileManageModel::platform($this->platform)->get();

        $clients = $collection->filter(function ($item) {

            if (in_array($item->device_client, $this->clients)) {
                return true;
            }

            return false;

        })->map(function ($item) {

            return [
                'app_id' => $item->app_id,
                'app_name' => $item->app_name,
                'platform' => $item->platform,
                'device_client' => $item->device_client,
                'device_code' => $item->device_code,
            ];

        });

        $clients = $clients->all();

        if (in_array('all', $this->clients)) {
            if (count($collection) > 1) {
                array_unshift($clients, [
                    'app_id' => 0,
                    'app_name' => __('统一设置', 'mobile'),
                    'platform' => $this->platform,
                    'device_client' => 'all',
                    'device_code' => 0,
                ]);
            }
        }

        return $clients;
    }


    public function getMobilePlatformClient($app_id)
    {
        $clients = $this->getMobilePlatformClients($this->platform);

        $data = collect($clients)->where('app_id', $app_id)->first();
        if (empty($client)) {
            $data = collect($clients)->first();
        }

        return $data;
    }


}