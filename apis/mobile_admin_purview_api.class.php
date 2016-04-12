<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 后台权限API
 * @author royalwang
 *
 */
class mobile_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(        		
        		array('action_name' => __('快捷菜单管理'), 'action_code' => 'shortcut_manage', 'relevance'   => ''),
        		array('action_name' => __('新增快捷菜单'), 'action_code' => 'shortcut_add', 'relevance'   => ''),
        		array('action_name' => __('编辑快捷菜单'), 'action_code' => 'shortcut_update', 'relevance'   => ''),
        		array('action_name' => __('删除菜单管理'), 'action_code' => 'shortcut_delete', 'relevance'   => ''),
        		
        		array('action_name' => __('轮播图管理'), 'action_code' => 'cycleimage_manage', 'relevance'   => ''),
        		array('action_name' => __('新增轮播图'), 'action_code' => 'cycleimage_add', 'relevance'   => ''),
        		array('action_name' => __('编辑轮播图'), 'action_code' => 'cycleimage_update', 'relevance'   => ''),
        		array('action_name' => __('删除轮播图'), 'action_code' => 'cycleimage_delete', 'relevance'   => ''),
        		
        		array('action_name' => __('百宝箱管理'), 'action_code' => 'discover_manage', 'relevance'   => ''),
        		array('action_name' => __('新增百宝箱'), 'action_code' => 'discover_add', 'relevance'   => ''),
        		array('action_name' => __('编辑百宝箱'), 'action_code' => 'discover_update', 'relevance'   => ''),
        		array('action_name' => __('删除百宝箱'), 'action_code' => 'discover_delete', 'relevance'   => ''),
        		
        		array('action_name' => __('移动设备管理'),    'action_code' => 'device_manage', 'relevance'   => ''),
        		array('action_name' => __('查看移动设备信息'), 'action_code' => 'device_detail', 'relevance'   => ''),
        		array('action_name' => __('更新移动设备信息'), 'action_code' => 'device_update', 'relevance'   => ''),
        		array('action_name' => __('删除移动设备'),     'action_code' => 'device_delete', 'relevance'   => ''),
  
        		array('action_name' => __('今日热点管理'),    'action_code' => 'mobile_news_manage', 'relevance'   => ''),
        		array('action_name' => __('新增今日热点'),    'action_code' => 'mobile_news_add', 'relevance'   => ''),
        		array('action_name' => __('编辑今日热点'),    'action_code' => 'mobile_news_update', 'relevance'   => ''),
        		array('action_name' => __('删除今日热点'),    'action_code' => 'mobile_news_delete', 'relevance'   => ''),
        		
        		array('action_name' => __('应用配置管理'), 'action_code' => 'mobile_config_manage', 'relevance'   => ''),
        		array('action_name' => __('编辑应用配置管理'), 'action_code' => 'mobile_config_update', 'relevance'   => ''),
        		
        		array('action_name' => __('移动应用管理'),    'action_code' => 'mobile_manage', 'relevance'   => ''),
        		array('action_name' => __('新增移动应用管理'),    'action_code' => 'mobile_manage_add', 'relevance'   => ''),
        		array('action_name' => __('编辑移动应用管理'),    'action_code' => 'mobile_manage_update', 'relevance'   => ''),
        		array('action_name' => __('删除移动应用管理'),    'action_code' => 'mobile_manage_delete', 'relevance'   => ''),
        		
        );
        
        return $purviews;
    }
}

// end