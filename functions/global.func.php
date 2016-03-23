<?php
/**
* 添加管理员记录日志操作对象
*/
function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_object('mobile_shortcut','快捷菜单');
	ecjia_admin_log::instance()->add_object('mobile_shortcut_display','快捷菜单是否显示');
	ecjia_admin_log::instance()->add_object('mobile_shortcut_sort','快捷菜单排序');
	
	ecjia_admin_log::instance()->add_object('mobile_discover','百宝箱');
	ecjia_admin_log::instance()->add_object('mobile_discover_display','百宝箱是否显示');
	ecjia_admin_log::instance()->add_object('mobile_discover_sort','百宝箱排序');
	
	ecjia_admin_log::instance()->add_object('mobile_device','移动设备');
	
	ecjia_admin_log::instance()->add_object('mobile_cycleimage','轮播图');
	ecjia_admin_log::instance()->add_object('mobile_config','配置');
	ecjia_admin_log::instance()->add_object('mobile_news','今日热点');
	ecjia_admin_log::instance()->add_object('mobile_manage','移动应用管理');
	
}

//end