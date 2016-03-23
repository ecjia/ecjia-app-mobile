<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 后台文章菜单API
 * @author royalwang
 *
 */
class mobile_admin_menu_api extends Component_Event_Api
{

    public function call(&$options)
    {
        $menus = ecjia_admin::make_admin_menu('07_content', __('移动应用'), '', 0);
        
        $submenus = array(
            ecjia_admin::make_admin_menu('01_mobile_list', __('快捷菜单'), RC_Uri::url('mobile/admin_shortcut/init'), 1)->add_purview('shortcut_manage'),
        	ecjia_admin::make_admin_menu('02_mobile_list', __('iPad轮播图'), RC_Uri::url('mobile/admin_cycleimage/init'), 2)->add_purview('cycleimage_manage'),
        	ecjia_admin::make_admin_menu('02_cycleimage_list', __('手机端轮播图'), RC_Uri::url('mobile/admin_cycleimage_phone/init'), 2)->add_purview('cycleimage_manage'),
        	ecjia_admin::make_admin_menu('03_discover_list', __('百宝箱'), RC_Uri::url('mobile/admin_discover/init'), 3)->add_purview('discover_manage'),
        	ecjia_admin::make_admin_menu('04_device_list', __('移动设备'), RC_Uri::url('mobile/admin_device/init'), 4)->add_purview('device_manage'),
        	ecjia_admin::make_admin_menu('05_mobile_news', __('今日热点'), RC_Uri::url('mobile/admin_mobile_news/init'), 5)->add_purview('mobile_news_manage'),
        	ecjia_admin::make_admin_menu('divider', '', '', 5)->add_purview('mobile_config_manage', 10),
        	ecjia_admin::make_admin_menu('05_config', __('应用配置'), RC_Uri::url('mobile/admin_config/init'), 6)->add_purview('mobile_config_manage'),
        	ecjia_admin::make_admin_menu('06_mobile_manage', __('客户端管理'), RC_Uri::url('mobile/admin_mobile_manage/init'), 6)->add_purview('mobile_push_config_manage')
        );
        
        $menus->add_submenu($submenus);
        
        return $menus;
    }
}

// end