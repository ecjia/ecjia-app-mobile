<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 后台文章菜单API
 * @author royalwang
 *
 */
class mobile_admin_menu_api extends Component_Event_Api {

    public function call(&$options) {
        $menus = ecjia_admin::make_admin_menu('07_content', RC_Lang::get('mobile::mobile.mobile_app'), '', 0);
        
        $submenus = array(
            ecjia_admin::make_admin_menu('01_mobile_list', RC_Lang::get('mobile::mobile.shorcut'), RC_Uri::url('mobile/admin_shortcut/init'), 1)->add_purview('shortcut_manage'),
        	ecjia_admin::make_admin_menu('02_cycleimage_list', RC_Lang::get('mobile::mobile.mobile_cycleimage'), RC_Uri::url('mobile/admin_cycleimage_phone/init'), 2)->add_purview('cycleimage_manage'),
//         	ecjia_admin::make_admin_menu('03_mobile_list', RC_Lang::get('mobile::mobile.ipad_cycleimage'), RC_Uri::url('mobile/admin_cycleimage/init'), 3)->add_purview('cycleimage_manage'),
        	ecjia_admin::make_admin_menu('04_discover_list', RC_Lang::get('mobile::mobile.discover'), RC_Uri::url('mobile/admin_discover/init'), 4)->add_purview('discover_manage'),
        	ecjia_admin::make_admin_menu('05_device_list', RC_Lang::get('mobile::mobile.mobile_device'), RC_Uri::url('mobile/admin_device/init'), 5)->add_purview('device_manage'),
        	ecjia_admin::make_admin_menu('06_mobile_news', RC_Lang::get('mobile::mobile.mobile_news'), RC_Uri::url('mobile/admin_mobile_news/init'), 6)->add_purview('mobile_news_manage'),
        	ecjia_admin::make_admin_menu('07_mobile_toutiao', RC_Lang::get('mobile::mobile.mobile_headline'), RC_Uri::url('mobile/admin_mobile_toutiao/init'), 7)->add_purview('mobile_news_manage'),
        	ecjia_admin::make_admin_menu('08_mobile_activity', RC_Lang::get('mobile::mobile.app_activity_list'), RC_Uri::url('mobile/admin_mobile_activity/init'), 8)->add_purview('mobile_activity_manage'),
        	ecjia_admin::make_admin_menu('divider', '', '', 9)->add_purview('mobile_config_manage', 9),
        	ecjia_admin::make_admin_menu('09_config', RC_Lang::get('mobile::mobile.mobile_config'), RC_Uri::url('mobile/admin_config/init'), 10)->add_purview('mobile_config_manage'),
        	ecjia_admin::make_admin_menu('10_mobile_manage', RC_Lang::get('mobile::mobile.mobile_manage'), RC_Uri::url('mobile/admin_mobile_manage/init'), 11)->add_purview('mobile_push_config_manage')
        );
        
        $menus->add_submenu($submenus);
        
        return $menus;
    }
}

// end