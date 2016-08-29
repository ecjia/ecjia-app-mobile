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
        	array('action_name' => RC_Lang::get('mobile::mobile.shortcut_manage'), 	'action_code' => 'shortcut_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.shortcut_add'), 	'action_code' => 'shortcut_add', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.shortcut_update'), 	'action_code' => 'shortcut_update', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.shortcut_delete'), 	'action_code' => 'shortcut_delete', 'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('mobile::mobile.cycleimage_manage'),	'action_code' => 'cycleimage_manage', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.cycleimage_add'), 		'action_code' => 'cycleimage_add', 		'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.cycleimage_update'), 	'action_code' => 'cycleimage_update', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.cycleimage_delete'), 	'action_code' => 'cycleimage_delete', 	'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('mobile::mobile.discover_manage'), 	'action_code' => 'discover_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.discover_add'), 	'action_code' => 'discover_add', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.discover_update'), 	'action_code' => 'discover_update', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.discover_delete'), 	'action_code' => 'discover_delete', 'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('mobile::mobile.mobile_device_manage'), 'action_code' => 'device_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.view_device_info'), 	'action_code' => 'device_detail', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.device_update'), 		'action_code' => 'device_update', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.device_delete'), 		'action_code' => 'device_delete', 'relevance' => ''),
  
        	array('action_name' => RC_Lang::get('mobile::mobile.mobile_news_manage'), 	'action_code' => 'mobile_news_manage', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.mobile_news_add'), 		'action_code' => 'mobile_news_add', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.mobile_news_update'), 	'action_code' => 'mobile_news_update', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.mobile_news_delete'), 	'action_code' => 'mobile_news_delete', 	'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('mobile::mobile.mobile_config_manage'), 'action_code' => 'mobile_config_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.mobile_config_update'), 'action_code' => 'mobile_config_update', 'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('mobile::mobile.mobile_app_manage'), 	'action_code' => 'mobile_manage', 			'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.mobile_manage_add'), 	'action_code' => 'mobile_manage_add', 		'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.mobile_manage_update'), 'action_code' => 'mobile_manage_update', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.mobile_manage_delete'), 'action_code' => 'mobile_manage_delete',	'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('mobile::mobile.mobile_toutiao_manage'), 'action_code' => 'mobile_toutiao_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('mobile::mobile.mobile_toutiao_delete'), 'action_code' => 'mobile_toutiao_delete', 'relevance' => ''),
        		
        	array('action_name' => __('活动管理'), 'action_code' => 'mobile_activity_manage', 'relevance' => ''),
        	array('action_name' => __('添加活动'), 'action_code' => 'mobile_activity_add', 'relevance' => ''),
        	array('action_name' => __('更新活动'), 'action_code' => 'mobile_activity_update', 'relevance' => ''),
        	array('action_name' => __('删除活动'), 'action_code' => 'mobile_activity_delete', 'relevance' => ''),
        	array('action_name' => __('活动记录'), 'action_code' => 'activity_record_manage', 'relevance' => ''),
        );
        
        return $purviews;
    }
}

// end