<?php
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_admin_hooks {
	
   public static function append_admin_setting_group($menus) 
   {
       $setting = ecjia_admin_setting::singleton();
       
       $menus[] = ecjia_admin::make_admin_menu('nav-header', '移动应用', '', 10)->add_purview(array('mobile_config_manage'));
       $menus[] = ecjia_admin::make_admin_menu('mobile', 'APP基本信息', RC_Uri::url('mobile/admin_config/init'), 6)->add_purview('mobile_config_manage');
       $menus[] = ecjia_admin::make_admin_menu('mobile', 'APP下载地址', RC_Uri::url('mobile/admin_config/init'), 6)->add_purview('mobile_config_manage');
       $menus[] = ecjia_admin::make_admin_menu('mobile', 'APP应用截图', RC_Uri::url('mobile/admin_config/init'), 6)->add_purview('mobile_config_manage');
       $menus[] = ecjia_admin::make_admin_menu('mobile', '移动广告位', RC_Uri::url('mobile/admin_config/init'), 6)->add_purview('mobile_config_manage');
       $menus[] = ecjia_admin::make_admin_menu('mobile', '登录页美化', RC_Uri::url('mobile/admin_config/init'), 6)->add_purview('mobile_config_manage');
       $menus[] = ecjia_admin::make_admin_menu('mobile', '热门城市', RC_Uri::url('mobile/admin_config/init'), 6)->add_purview('mobile_config_manage');
       $menus[] = ecjia_admin::make_admin_menu('mobile', '消息提醒', RC_Uri::url('mobile/admin_config/init'), 6)->add_purview('mobile_config_manage');
       
       return $menus;
   }
    
}

RC_Hook::add_action( 'append_admin_setting_group', array('mobile_admin_hooks', 'append_admin_setting_group') );


// end