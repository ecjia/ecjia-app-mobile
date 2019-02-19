<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 10:00
 */

namespace Ecjia\App\Mobile;


use Ecjia\App\Mobile\Contracts\ApplicationOptionInterface;
use Ecjia\App\Mobile\Models\MobileOptionModel;
use Royalcms\Component\Database\Eloquent\Collection;

class ApplicationPlatformOption implements ApplicationOptionInterface
{

    protected $platform;

    public function __construct(ApplicationPlatform $platform)
    {
        $this->platform = $platform;
    }


    /**
     * 获取所有选项
     * @return array
     */
    public function getOptions()
    {
        $model = new MobileOptionModel();

        $data = $model->platform($this->platform->getCode())->appid(0)->get();

        if ($data) {
            $data = $this->processOptionValue($data);
        }

        return $data;
    }

    /**
     * 获取单个选项值
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function getOption($key, $default = null)
    {
        $options = $this->getOptions();

        return array_get($options, $key, $default);
    }

    /**
     *
     * @return array
     */
    protected function processOptionValue(Collection $data)
    {
        $result = $data->mapWithKeys(function ($item) {

            if ($item->option_type == 'serialize') {
                $values = unserialize($item->option_value);
            } else {
                $values = $item->option_value;
            }

            return array($item->option_name => $values);
        })->all();

        return $result;
    }

}