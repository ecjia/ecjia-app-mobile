<?php


class redirect extends ecjia_front
{
    
    public function __construct() {
        parent::__construct();	
    }
    
    
    public function init() {
        
        $request = royalcms('request');
        
        $handle = $request->query('handle');
        
        if ($handle != 'ecjiaopen') {
            
            $this->showmessage('Invalid parameter', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
            
        }
        
        $open_type = $request->query('open_type');
        
        // 商品祥情跳转
        if ($open_type == 'goods_detail') 
        {
            $goods_id = $request->query('goods_id');
            $url = RC_Uri::url('goods/index/show', array('goods_id' => $goods_id));
            $url = str_replace(RC_Uri::site_url(), RC_Uri::home_url().'/sites/m', $url);
            $this->redirect($url);
        }
        // 商家主页跳转
        elseif ($open_type == 'merchant') 
        {
            $store_id = $request->query('merchant_id');
            $url = RC_Uri::url('merchant/index/init', array('store_id' => $store_id));
            $url = str_replace(RC_Uri::site_url(), RC_Uri::home_url().'/sites/m', $url);
            $this->redirect($url);
        }
        else 
        {
            $this->showmessage('Invalid parameter', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }
        
    }
    
    
}