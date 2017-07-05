<?php

namespace Ecjia\App\Mobile;

class ApplicationPlatform
{
    /**
     * 代号标识
     * @var string
     */
    protected $code;
    
    /**
     * 名称
     * @var string
     */
    protected $name;
    
    /**
     * 描述
     * @var string
     */
    protected $desciption;
    
    /**
     * 支持的客户端类型
     * @var array
     */
    protected $clients = [
    	'iphone',
        'android'
    ];
    
    
    public function getCode()
    {
        return $this->code;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function getClients()
    {
        return $this->clients;
    }
    
    
}