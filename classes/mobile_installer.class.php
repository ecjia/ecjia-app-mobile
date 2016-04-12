<?php
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_installer  extends ecjia_installer {

    protected $dependent = array(
        'ecjia.system'    => '1.0',
    );

    public function __construct() {
        $id = 'ecjia.mobile';
        parent::__construct($id);
    }
    
    
    public function install() {
    	/* 设备信息*/
        $table_name = 'mobile_device';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
                "`device_udid` char(40) NOT NULL DEFAULT ''",
                "`device_client` char(10) NOT NULL DEFAULT ''",
                "`device_code` char(4) NOT NULL DEFAULT ''",
                "`device_name` varchar(30) DEFAULT NULL",
                "`device_alias` varchar(30) DEFAULT NULL",
                "`device_token` char(64) DEFAULT NULL",
                "`device_os` varchar(30) DEFAULT NULL",
                "`user_id` int(9) NOT NULL DEFAULT '0'",
                "`is_admin` tinyint(1) NOT NULL DEFAULT '0'",
                "`location_province` varchar(20) DEFAULT NULL",
                "`location_city` varchar(20) DEFAULT NULL",
                "`in_status` tinyint(1) NOT NULL",
                "`add_time` int(10) NOT NULL",
                "PRIMARY KEY (`id`)",
                "UNIQUE KEY `device_udid` (`device_udid`,`device_client`,`device_code`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        /* 今日热点*/
        $table_name = 'mobile_news';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			"`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
        			"`group_id` int(11) NOT NULL",
        			"`title` varchar(100) DEFAULT NULL",
        			"`description` varchar(255) DEFAULT NULL",
        			"`image` varchar(100) DEFAULT NULL",
        			"`content_url` varchar(100) DEFAULT NULL",
        			"`type` char(10) NOT NULL DEFAULT ''",
        			"`status` tinyint(3) NOT NULL DEFAULT '0'",
        			"`create_time` int(10) NOT NULL",
        			"PRIMARY KEY (`id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        
        $table_name = 'mobile_message';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			"`message_id` int(11) unsigned NOT NULL AUTO_INCREMENT",
        			"`sender_id` int(11) NOT NULL DEFAULT '0'",
        			"`sender_admin` tinyint(1) NOT NULL",
        			"`receiver_id` int(11) NOT NULL DEFAULT '0'",
        			"`receiver_admin` tinyint(1) NOT NULL",
        			"`send_time` int(11) unsigned NOT NULL DEFAULT '0'",
        			"`read_time` int(11) unsigned NOT NULL DEFAULT '0'",
        			"`readed` tinyint(1) unsigned NOT NULL DEFAULT '0'",
        			"`deleted` tinyint(1) unsigned NOT NULL DEFAULT '0'",
        			"`title` varchar(150) NOT NULL DEFAULT ''",
        			"`message` text NOT NULL",
        			"`message_type` varchar(25) NOT NULL",
        			"PRIMARY KEY (`message_id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
		
        /* 客户端管理*/
        $table_name = 'mobile_manage';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`app_id` int(10) unsigned NOT NULL AUTO_INCREMENT",
                "`app_name` varchar(100) NOT NULL DEFAULT '' COMMENT '应用名称'",
                "`bundle_id` varchar(100) NOT NULL DEFAULT '' COMMENT 'app包名'",
                "`app_key` varchar(100) NOT NULL DEFAULT '' COMMENT 'appkey'",
                "`app_secret` varchar(100) NOT NULL DEFAULT '' COMMENT 'AppSecret'",
                "`device_code` char(4) NOT NULL",
                "`device_client` char(10) NOT NULL DEFAULT ''",
                "`platform` varchar(50) NOT NULL DEFAULT '' COMMENT '服务平台名称'",
                "`add_time` int(10) unsigned NOT NULL DEFAULT '0'",
                "`status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态'",
                "`sort` smallint(4) unsigned NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`app_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /* 今日头条*/
        $table_name = 'mobile_toutiao';
    	if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
                "`title` varchar(100) DEFAULT NULL",
                "`tag` varchar(20) DEFAULT NULL",
                "`description` varchar(255) DEFAULT NULL",
                "`image` varchar(100) DEFAULT NULL",
                "`content_url` varchar(100) DEFAULT NULL",
                "`sort_order` smallint(4) unsigned NOT NULL DEFAULT '100'",
                "`status` tinyint(1) unsigned NOT NULL DEFAULT '1'",
                "`create_time` int(10) unsigned NOT NULL DEFAULT '0'",
                "`update_time` int(10) unsigned NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /* 扫码登录*/
        $table_name = 'qrcode_validate';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			"`user_id` int(40) NOT NULL COMMENT 'user_id'",
        			"`is_admin` bit(1) NOT NULL COMMENT '是否是管理员'",
        			"`uuid` varchar(20) NOT NULL COMMENT 'code'",
        			"`status` tinyint(4) NOT NULL COMMENT '状态'",
        			"`expires_in` int(11) NOT NULL COMMENT '有效期'",
        			"`device_udid` char(40) DEFAULT NULL",
        			"`device_client` char(10) DEFAULT NULL",
        			"`device_code` char(4) DEFAULT NULL",
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        RC_Loader::load_app_class('mobile_method', 'mobile');
        if (!ecjia::config(mobile_method::STORAGEKEY_discover_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', mobile_method::STORAGEKEY_discover_data, serialize(array()), array('type' => 'hidden'));
        }
        if (!ecjia::config(mobile_method::STORAGEKEY_shortcut_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', mobile_method::STORAGEKEY_shortcut_data, serialize(array()), array('type' => 'hidden'));
        }
        if (!ecjia::config(mobile_method::STORAGEKEY_cycleimage_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', mobile_method::STORAGEKEY_cycleimage_data, serialize(array()), array('type' => 'hidden'));
        }
        
        if (!ecjia::config(mobile_method::STORAGEKEY_cycleimage_phone_data, ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', mobile_method::STORAGEKEY_cycleimage_phone_data, serialize(array()), array('type' => 'hidden'));
        }
        
        if (!ecjia::config('mobile_iphone_qr_code', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'mobile_iphone_qr_code', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('mobile_ipad_qr_code', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'mobile_ipad_qr_code', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('mobile_android_qr_code', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'mobile_android_qr_code', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('mobile_launch_adsense', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'mobile_launch_adsense', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('mobile_tv_adsense_group', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'mobile_tv_adsense_group', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('mobile_home_adsense_group', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'mobile_home_adsense_group', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('mobile_recommend_city', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'mobile_recommend_city', '', array('type' => 'hidden'));
        }
        /* pad 登录页颜色设置*/
        if (!ecjia::config('mobile_pad_login_fgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'mobile_pad_login_fgcolor', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('mobile_pad_login_bgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'mobile_pad_login_bgcolor', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('mobile_pad_login_bgimage', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'mobile_pad_login_bgimage', '', array('type' => 'hidden'));
        }
        /* 手机  登录页颜色设置*/
        if (!ecjia::config('mobile_phone_login_fgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'mobile_phone_login_fgcolor', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('mobile_phone_login_bgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'mobile_phone_login_bgcolor', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('mobile_phone_login_bgimage', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'mobile_phone_login_bgimage', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('bonus_readme_url', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'bonus_readme_url', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('mobile_feedback_autoreply', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'mobile_feedback_autoreply', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('mobile_topic_adsense', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'mobile_topic_adsense', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('mobile_app_icon', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'mobile_app_icon', '', array('type' => 'hidden'));
        }
        
        return true;
    }
    
    
    public function uninstall() {
        $table_name = 'mobile_device';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'mobile_news';
        if (RC_Model::make()->table_exists($table_name)) {
        	RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'mobile_message';
        if (RC_Model::make()->table_exists($table_name)) {
        	RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'mobile_manage';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
    	$table_name = 'mobile_toutiao';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        RC_Loader::load_app_class('mobile_method', 'mobile');
        if (ecjia::config(mobile_method::STORAGEKEY_discover_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config(mobile_method::STORAGEKEY_discover_data);
        }
        if (ecjia::config(mobile_method::STORAGEKEY_shortcut_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config(mobile_method::STORAGEKEY_shortcut_data);
        }
        if (ecjia::config(mobile_method::STORAGEKEY_cycleimage_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config(mobile_method::STORAGEKEY_cycleimage_data);
        }
        
        if (ecjia::config('mobile_iphone_qr_code', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_iphone_qr_code');
        }
        if (ecjia::config('mobile_ipad_qr_code', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_ipad_qr_code');
        }
        if (ecjia::config('mobile_android_qr_code', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_android_qr_code');
        }
        if (ecjia::config('mobile_launch_adsense', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('mobile_launch_adsense');
        }
        if (ecjia::config('mobile_tv_adsense_group', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('mobile_tv_adsense_group');
        }
        
        if (ecjia::config('mobile_home_adsense_group', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_home_adsense_group');
        }
        if (ecjia::config('mobile_recommend_city', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_recommend_city');
        }
        /* 删除pad 登录页颜色设置*/
        if (ecjia::config('mobile_pad_login_fgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_pad_login_fgcolor');
        }
        if (ecjia::config('mobile_pad_login_bgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_pad_login_bgcolor');
        }
        if (ecjia::config('mobile_pad_login_bgimage', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_pad_login_bgimage');
        }
        /* 删除手机  登录页颜色设置*/
        if (ecjia::config('mobile_phone_login_fgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_phone_login_fgcolor');
        }
        if (ecjia::config('mobile_phone_login_bgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_phone_login_bgcolor');
        }
        if (ecjia::config('mobile_phone_login_bgimage', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_phone_login_bgimage');
        }
        
        if (ecjia::config('bonus_readme_url', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('bonus_readme_url');
        }
        if (ecjia::config('mobile_feedback_autoreply', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_feedback_autoreply');
        }
        if (ecjia::config('mobile_topic_adsense', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_topic_adsense');
        }
        if (ecjia::config('mobile_app_icon', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_app_icon');
        }
        
        return true;
    }
    
}

// end