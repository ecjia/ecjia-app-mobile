<?php

namespace Ecjia\App\Mobile;

class MobileOpenType
{
    
    protected $name;
    
    
    protected $opentype;
    
    
    protected $args = array();
    
    
    protected $schema = 'ecjiaopen://';
    
    protected $openurl;
    
    
    public function __construct($name, $opentype, array $args = array())
    {
        $this->name = $name;
        $this->opentype = $opentype;
        $this->args = $args;
        
        $this->buildEcjiaOpen();
    }
    
    
    public function getName()
    {
        return $this->name;
    }
    
    
    public function getOpenType()
    {
        return $this->opentype;
    }
    
    
    public function getArguments()
    {
        return $this->args;
    }
    
    public function getOpenUrl()
    {
        return $this->openurl;
    }
    
    protected function buildEcjiaOpen()
    {
        $data = array('open_type' => $this->opentype);
        $data = array_merge($data, $this->args);
     
        $this->openurl = $this->schema . http_build_query($data);
    }
    
    
    
}