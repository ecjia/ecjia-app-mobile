<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 10:00
 */

namespace Ecjia\App\Mobile;


use Ecjia\App\Mobile\Contracts\ApplicationOptionInterface;
use Ecjia\App\Mobile\Models\MobileManageModel;
use Royalcms\Component\Database\Eloquent\Collection;

class ApplicationClientOption implements ApplicationOptionInterface
{

    protected $client;

    public function __construct(ApplicationClient $client)
    {
        $this->client = $client;
    }


    /**
     * 获取所有选项
     * @return array
     */
    public function getOptions()
    {
        $model = new MobileManageModel();

        $data = $model->platform($this->client->getPlatformCode())->app($this->client->getDeviceCode())->enabled()->first();
        if ($data) {
            $data = $data->options;
            $data = $this->processOptionValue($data);

            return $data;
        }

        return null;
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