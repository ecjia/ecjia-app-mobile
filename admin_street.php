<?php

defined('IN_ECJIA') or exit('No permission resources.');


class admin_street extends ecjia_admin
{
    
    public function __construct()
    {
        parent::__construct();
        
        RC_Loader::load_app_class('mobile_qrcode', 'mobile', false);
        RC_Style::enqueue_style('mobile_street', RC_App::apps_url('statics/css/mobile_street.css', __FILE__));
    }
    
    
    public function init()
    {
    	//$this->admin_priv('mobile_street');
    	$this->assign('ur_here', '店铺街介绍');
        ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('店铺街APP')));
        $mobile_img = RC_App::apps_url('statics/images/mobile_img.png', __FILE__);
        $ec_icon    = RC_App::apps_url('statics/images/ec_icon.png', __FILE__);
        $dianpujie = RC_App::apps_url('statics/images/dianpujie.png', __FILE__);
        
        if (!empty($_GET['size'])) {
        	$size = trim($_GET['size']);
        	$street_qrcode = mobile_qrcode::getStreetQrcodeUrl($size);
        } else {
        	$street_qrcode = mobile_qrcode::getStreetQrcodeUrl();
        }
        $api_url = mobile_qrcode::getApiUrl();
        
        $this->assign('api_url', $api_url);
        $this->assign('mobile_img', $mobile_img);
        $this->assign('ec_icon', $ec_icon);
        $this->assign('street_qrcode', $street_qrcode);
        $this->assign('dianpujie', $dianpujie);
        
        $this->display('mobile_street.dwt');
    }
}

// end