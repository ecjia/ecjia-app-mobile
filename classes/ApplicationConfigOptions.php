<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-22
 * Time: 15:23
 */

namespace Ecjia\App\Mobile;

use RC_Uri;

class ApplicationConfigOptions
{

    /**
     * @var ApplicationPlatform
     */
    protected $platform;

    /**
     * @var int
     */
    protected $app_id;

    public function __construct(ApplicationPlatform $platform, $app_id)
    {
        $this->platform = $platform;
        $this->app_id = $app_id;
    }

    public function getPlatform()
    {
        return $this->platform;
    }

    public function getAppId()
    {
        return $this->app_id;
    }

    public function getConfigGroups()
    {

        $allowKeys = $this->platform->getMobileOptionKeys();
        $optionKeys = (new \Ecjia\App\Mobile\ApplicationConfigFactory)->getOptionKeys();

        $options = $this;
        $defaults = collect($optionKeys)->filter(function($item) use ($allowKeys) {

            if (in_array($item->getCode(), $allowKeys)) {
                return true;
            }

            return false;

        })->map(function($item) use ($options) {

            $item->setApplicationConfigOptions($options);

            return $item->toArray();
        })->all();

        return $defaults;
    }

    public function getOptionKey($code)
    {
        return (new \Ecjia\App\Mobile\ApplicationConfigFactory)->getOptionKey($code)->setApplicationConfigOptions($this);
    }

}