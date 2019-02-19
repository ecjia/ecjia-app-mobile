<?php

namespace Ecjia\App\Mobile;

class ApplicationClient
{
    /**
     * 设备客户端类型
     * @var string
     */
    protected $device_client;
    
    /**
     * 设备名称
     * @var string
     */
    protected $device_name;
    
    /**
     * 客户端代号
     * @var string
     */
    protected $device_code;
    
    /**
     * 平台代号
     * @var string
     */
    protected $platform_code;
    
    
    /**
     * 平台对象
     * @var \Ecjia\App\Mobile\ApplicationPlatform
     */
    protected $platform;
    
    
    public function setDeviceClient($device_client)
    {
        $this->device_client = $device_client;
        
        return $this;
    }
    
    public function getDeviceClient()
    {
        return $this->device_client;
    }
    
    
    public function setDeviceName($device_name)
    {
        $this->device_name = $device_name;
        
        return $this;
    }
    
    
    public function getDeviceName()
    {
        return $this->device_name;
    }
    
    
    public function setDeviceCode($device_code)
    {
        $this->device_code = $device_code;
        
        return $this;
    }
    
    
    public function getDeviceCode()
    {
        return $this->device_code;
    }
    
    
    public function setPlatformCode($platform_code)
    {
        $this->platform_code = $platform_code;
        
        return $this;
    }
    
    
    public function getPlatformCode()
    {
        return $this->platform_code;
    }
    
    /**
     * 
     * @param ApplicationPlatform $platform
     * @return \Ecjia\App\Mobile\ApplicationClient
     */
    public function setPlatform(ApplicationPlatform $platform)
    {
        $this->platform = $platform;
        
        return $this;
    }
    
    /**
     * 
     * @return \Ecjia\App\Mobile\ApplicationPlatform
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @return ApplicationClientOption
     */
    public function getApplicationClientOption()
    {
        return new ApplicationClientOption($this);
    }

    /**
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->getApplicationClientOption()->getOptions();
    }
    
    /**
     * 获取当前客户端选项，没有就获取平台的选项
     * @param string $name
     * @return array
     */
    public function getOption($name, $default = null)
    {
        $options = $this->getOptions();

        if (empty($options)) {
            $options = $this->getPlatform()->getOptions();
        }

        $value = array_get($options, $name);

        if (empty($value)) {
            $value = array_get($this->getPlatform()->getOptions(), $name, $default);
        }

        return $value;
    }
    
}