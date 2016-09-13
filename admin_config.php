<?php

/**
 * ECJIA移动应用配置模块
 */

defined('IN_ECJIA') or exit('No permission resources.');

class admin_config extends ecjia_admin {
	private $db_config;
	private $db_region;
	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
	
		$this->db_config = RC_Loader::load_model('shop_config_model'); 
		$this->db_region = RC_Model::model('shipping/region_model');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('bootstrap-placeholder');
		
		RC_Style::enqueue_style('mobile_config', RC_App::apps_url('statics/css/mobile_config.css', __FILE__), array(), false, false);
		RC_Style::enqueue_style('goods-colorpicker-style', RC_Uri::admin_url('/statics/lib/colorpicker/css/colorpicker.css'));
		RC_Script::enqueue_script('goods-colorpicker-script', RC_Uri::admin_url('/statics/lib/colorpicker/bootstrap-colorpicker.js'), array());
		
		RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
		
		RC_Script::enqueue_script('mobile_config', RC_App::apps_url('statics/js/mobile_config.js', __FILE__), array(), false, false);
		RC_Script::localize_script('mobile_config', 'js_lang', RC_Lang::get('mobile::mobile.js_lang'));
	}

					
	/**
	 * 移动应用配置页面
	 */
	public function init () {
	    $this->admin_priv('mobile_config_manage', ecjia::MSGTYPE_JSON);
	    
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.mobile_config'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_config')));
		
		$ad_position_list = RC_Api::api('adsense', 'adsense_position_list');
		
		$mobile_home_adsense_group = $adsense_group = array();
		if (ecjia::config('mobile_home_adsense_group', ecjia::CONFIG_EXISTS)) {
			$adsense_group = explode(',', ecjia::config('mobile_home_adsense_group'));
		}
		
		if (!empty($adsense_group)) {
			foreach ($adsense_group as $val) {
				$adsense = RC_Api::api('adsense', 'adsense_position_list', array('position_id' => $val));
				if (!empty($adsense['arr'])) {
					$mobile_home_adsense_group[] = $adsense['arr'][0];
				}
			}
		}
		
		$mobile_recommend_city = explode(',', ecjia::config('mobile_recommend_city'));
		$regions = array ();
//		$region_data = $this->db_region->where(array('region_id' => $mobile_recommend_city ))->select();
		$region_data = RC_DB::table('region')->whereIn('region_id', $mobile_recommend_city)->get();

		if (!empty($region_data)) {
			foreach ( $region_data as $key => $val ) {
				if ( empty($val['region_name']) ) {
					$regions[$val['region_id']] = '<lable  style="color:red">' .RC_Lang::get('mobile::mobile.region_removed'). '</lable>';
				} else {
					$regions[$val['region_id']] = $val['region_name'];
				}
			}
		}
		
		$mobile_iphone_qr_code = ecjia::config('mobile_iphone_qr_code');
		$mobile_iphone_qr_code = empty($mobile_iphone_qr_code) ? '' : RC_Upload::upload_url() .'/'.$mobile_iphone_qr_code;
		$mobile_android_qr_code = ecjia::config('mobile_android_qr_code');
		$mobile_android_qr_code = empty($mobile_android_qr_code) ? '' : RC_Upload::upload_url() .'/'.$mobile_android_qr_code;
		$mobile_ipad_qr_code = ecjia::config('mobile_ipad_qr_code');
		$mobile_ipad_qr_code = empty($mobile_ipad_qr_code) ? '' : RC_Upload::upload_url() .'/'.$mobile_ipad_qr_code;
		
		$mobile_pad_login_bgimage = ecjia::config('mobile_pad_login_bgimage');
		$mobile_phone_login_bgimage = ecjia::config('mobile_phone_login_bgimage');
		
		$mobile_pad_login_bgimage = empty($mobile_pad_login_bgimage) ? '' : RC_Upload::upload_url() .'/'.$mobile_pad_login_bgimage;
		$mobile_phone_login_bgimage = empty($mobile_phone_login_bgimage) ? '' : RC_Upload::upload_url() .'/'.$mobile_phone_login_bgimage;
		$mobile_app_icon = ecjia::config('shop_app_icon', ecjia::CONFIG_EXISTS) ? RC_Upload::upload_url() . '/' . ecjia::config('shop_app_icon') : '';
		
		$wap_logo = ecjia::config('wap_logo', ecjia::CONFIG_EXISTS) ? RC_Upload::upload_url() . '/' . ecjia::config('wap_logo') : '';
		
		$bonus_readme_url = ecjia::config('bonus_readme_url');
		$bonus_readme = array();
		if (!empty($bonus_readme_url)) {
			$bonus_readme_url = explode('?', $bonus_readme_url);
			$parameter = explode('&', end($bonus_readme_url));
			foreach($parameter as $val){
				$tmp = explode('=',$val);
				$data[$tmp[0]] = $tmp[1];
			}
			$article_info = RC_Api::api('article', 'article_info', array('id' => $data['id']));
			if (!is_ecjia_error($article_info)) {
				if (!empty($article_info)) {
					$bonus_readme = array('id' => $data['id'], 'title' => $article_info['title']);
				}
			}
		}
		$this->assign('bonus_readme', $bonus_readme);
		
		$this->assign('mobile_iphone_qr_code', $mobile_iphone_qr_code);
		$this->assign('mobile_ipad_qr_code', $mobile_ipad_qr_code);
		$this->assign('mobile_android_qr_code', $mobile_android_qr_code);
		$this->assign('mobile_app_icon', $mobile_app_icon);
	  	$this->assign('mobile_launch_adsense', ecjia::config('mobile_launch_adsense'));
	  	$this->assign('mobile_home_adsense_group', $mobile_home_adsense_group);
	  	
	  	$mobile_tv_home_adsense_group = $tv_adsense_group = array();
	  	if (ecjia::config('mobile_home_adsense_group', ecjia::CONFIG_EXISTS)) {
	  		$tv_adsense_group = explode(',', ecjia::config('mobile_tv_home_adsense_group'));
	  	}
	  	
	  	if (!empty($tv_adsense_group)) {
	  		foreach ($tv_adsense_group as $val) {
	  			$tv_adsense = RC_Api::api('adsense', 'adsense_position_list', array('position_id' => $val));
	  			if (!empty($tv_adsense['arr'])) {
	  				$mobile_tv_home_adsense_group[] = $tv_adsense['arr'][0];
	  			}
	  		}
	  	}
	  	
	  	$this->assign('mobile_tv_home_adsense', ecjia::config('mobile_tv_home_adsense'));
	  	$this->assign('mobile_tv_home_adsense_group', $mobile_tv_home_adsense_group);
	  	
	  	$mobile_tv_adsense_group = unserialize(ecjia::config('mobile_tv_adsense_group'));
	  	$this->assign('mobile_tv_big_adsense', $mobile_tv_adsense_group['big_group']);
	  	$this->assign('mobile_tv_small_adsense', $mobile_tv_adsense_group['small_group']);
	  	
	  	
	  	$this->assign('mobile_recommend_city', $regions);
//	  	$this->assign('countries', $this->db_region->get_regions());
	  	$this->assign('countries', $this->get_regions());

	  	$this->assign('ad_position_list', $ad_position_list['arr']);
		$this->assign('form_action', RC_Uri::url('mobile/admin_config/update'));
		
		$this->assign('mobile_pad_login_fgcolor', ecjia::config('mobile_pad_login_fgcolor'));
		$this->assign('mobile_pad_login_bgcolor', ecjia::config('mobile_pad_login_bgcolor'));
		$this->assign('mobile_pad_login_bgimage', $mobile_pad_login_bgimage);
		$this->assign('mobile_phone_login_fgcolor', ecjia::config('mobile_phone_login_fgcolor'));
		$this->assign('mobile_phone_login_bgcolor', ecjia::config('mobile_phone_login_bgcolor'));
		$this->assign('mobile_phone_login_bgimage', $mobile_phone_login_bgimage);
		
		$this->assign('shop_app_description', ecjia::config('shop_app_description'));
		$this->assign('shop_iphone_download', ecjia::config('shop_iphone_download'));
		$this->assign('shop_android_download', ecjia::config('shop_android_download'));
		$this->assign('shop_ipad_download', ecjia::config('shop_ipad_download'));
		$this->assign('shop_touch_url', ecjia::config('shop_touch_url'));
		$this->assign('shop_pc_url', ecjia::config('shop_pc_url'));
		$this->assign('wap_logo', $wap_logo);
		$this->assign('wap_config', ecjia::config('wap_config'));
		
		$this->assign('mobile_feedback_autoreply', ecjia::config('mobile_feedback_autoreply'));
		$this->assign('mobile_topic_adsense', ecjia::config('mobile_topic_adsense'));
		$this->assign('mobile_shopkeeper_urlscheme', ecjia::config('mobile_shopkeeper_urlscheme'));
		$this->assign('mobile_shop_urlscheme', ecjia::config('mobile_shop_urlscheme'));
		
		
		/* 签到送积分*/
		$this->assign('checkin_award_open', ecjia::config('checkin_award_open'));
		$this->assign('checkin_award', ecjia::config('checkin_award'));
		$checkin_extra_award = ecjia::config('checkin_extra_award');
		$checkin_extra_award = unserialize($checkin_extra_award);
		$this->assign('checkin_extra_day', $checkin_extra_award['day']);
		$this->assign('checkin_extra_award', $checkin_extra_award['extra_award']);
		
		
		/* 评论送积分*/
		$user_rank_list = array();
		$db_user_rank = RC_Model::model('user/user_rank_model');
		$data = $db_user_rank->field('rank_id, rank_name')->select();
		if (!empty($data)) {
			$comment_award_rules = unserialize(ecjia::config('comment_award_rules'));
			
			foreach ($data as $row) {
				if (!empty($comment_award_rules[$row['rank_id']])) {
					$row['comment_award'] = $comment_award_rules[$row['rank_id']];
				}
				$user_rank_list[] = $row;
			}
		}
		$this->assign('user_rank_list', $user_rank_list);
		$this->assign('comment_award_open', ecjia::config('comment_award_open'));
		$this->assign('comment_award', ecjia::config('comment_award'));
		
		/* 推荐分成说明设置*/
		$recommend_notice			= ecjia::config('recommend_notice');
		$share_notice				= ecjia::config('share_notice');
		$this->assign('recommend_notice', $recommend_notice);
		$this->assign('share_notice', $share_notice);
		
		/* 管理员信息*/
//		$admin_user_list = RC_Model::model('user/admin_user_model')->field(array('user_id', 'user_name'))->select();
		$admin_user_list = RC_DB::table('admin_user')->select('user_id', 'user_name')->get();
		$this->assign('admin_user_list', $admin_user_list);
		$order_reminder_type = ecjia::config('order_reminder_type', ecjia::CONFIG_CHECK) ? ecjia::config('order_reminder_type') : 0;
		
		$this->assign('order_reminder_type', $order_reminder_type);
		$this->assign('order_reminder_value', ecjia::config('order_reminder_value'));
		
		$this->display('mobile_config.dwt');
	}
		
	/**
	 * 处理移动应用配置
	 */
	public function update() {
		$this->admin_priv('mobile_config_update', ecjia::MSGTYPE_JSON);
		
		$mobile_tv_big_adsense 			= !empty($_POST['mobile_tv_big_adsense']) 		? $_POST['mobile_tv_big_adsense'] 				: '';
		$mobile_tv_small_adsense 		= !empty($_POST['mobile_tv_small_adsense']) 	? $_POST['mobile_tv_small_adsense'] 			: '';
		$mobile_launch_adsense 			= !empty($_POST['mobile_launch_adsense']) 		? $_POST['mobile_launch_adsense'] 				: '';
		$regions 						= isset($_POST['regions']) 						? $_POST['regions'] 							: '';
		$mobile_pad_login_fgcolor 		= !empty($_POST['mobile_pad_login_fgcolor']) 	? trim($_POST['mobile_pad_login_fgcolor']) 		: '';
		$mobile_pad_login_bgcolor 		= !empty($_POST['mobile_pad_login_bgcolor']) 	? trim($_POST['mobile_pad_login_bgcolor']) 		: '';
		$mobile_phone_login_fgcolor 	= !empty($_POST['mobile_phone_login_fgcolor']) 	? trim($_POST['mobile_phone_login_fgcolor']) 	: '';
		$mobile_phone_login_bgcolor 	= !empty($_POST['mobile_phone_login_bgcolor']) 	? trim($_POST['mobile_phone_login_bgcolor']) 	: '';
		$bonus_readme 					= !empty($_POST['bonus_readme']) 				? $_POST['bonus_readme'] 						: '';
		$mobile_feedback_autoreply 		= !empty($_POST['mobile_feedback_autoreply']) 	? trim($_POST['mobile_feedback_autoreply']) 	: '';
		$mobile_topic_adsense 			= !empty($_POST['mobile_topic_adsense']) 		? $_POST['mobile_topic_adsense'] 				: '';
		$mobile_shopkeeper_urlscheme 	= !empty($_POST['mobile_shopkeeper_urlscheme']) ? trim($_POST['mobile_shopkeeper_urlscheme']) 	: '';
		$mobile_shop_urlscheme 			= !empty($_POST['mobile_shop_urlscheme']) 		? trim($_POST['mobile_shop_urlscheme']) 		: '';
		$adsense_group 					= !empty($_POST['mobile_home_adsense_group']) 	? $_POST['mobile_home_adsense_group'] 			: '';
		
		$shop_app_description 			= !empty($_POST['shop_app_description']) 	? trim($_POST['shop_app_description']) 	: '';
		$shop_iphone_download 			= !empty($_POST['shop_iphone_download']) 	? trim($_POST['shop_iphone_download']) 	: '';
		$shop_android_download 			= !empty($_POST['shop_android_download']) 	? trim($_POST['shop_android_download']) : '';
		$shop_ipad_download 			= !empty($_POST['shop_ipad_download']) 		? trim($_POST['shop_ipad_download']) 	: '';
		$shop_pc_url 					= !empty($_POST['shop_pc_url']) 			? trim($_POST['shop_pc_url']) 			: '';
		$shop_touch_url 				= !empty($_POST['shop_touch_url']) 			? trim($_POST['shop_touch_url']) 		: '';
		$wap_config 					= isset($_POST['wap_config']) ? 1 : 0;
		
		$mobile_home_adsense_group = '';
		$checkin_extra_award_value = '';
		$mobile_recommend_city = '';
		if (!empty($regions)) {
			foreach ($regions as $val) {
				$mobile_recommend_city .= $val.',';
			}
			$mobile_recommend_city = substr($mobile_recommend_city, 0, -1);
		}
		if (!empty($adsense_group)) {
			$mobile_home_adsense_group = '';
			foreach ($adsense_group as $val) {
				$mobile_home_adsense_group .= $val.',';
			}
			$mobile_home_adsense_group = substr($mobile_home_adsense_group, 0, -1);
		}
		
		$tv_sadsense_group = !empty($_POST['mobile_tv_home_adsense_group']) 	? $_POST['mobile_tv_home_adsense_group'] 			: '';
		
		$mobile_tv_home_adsense_group = '';
		if (!empty($tv_sadsense_group)) {
			foreach ($tv_sadsense_group as $val) {
				$mobile_tv_home_adsense_group .= $val.',';
			}
			$mobile_tv_home_adsense_group = substr($mobile_tv_home_adsense_group, 0, -1);
		}
		
		ecjia_config::instance()->write_config('mobile_tv_home_adsense_group', $mobile_tv_home_adsense_group);
		ecjia_config::instance()->write_config('mobile_tv_home_adsense', intval($_POST['mobile_tv_home_adsense']));
		/* iphone二维码上传*/
		if (isset($_FILES['mobile_iphone_qr_code'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'auto_sub_dirs' => false));
			$upload->add_filename_callback(function () { return 'mobile_iphone_qr_code';});
			
			$image_info = $upload->upload($_FILES['mobile_iphone_qr_code']);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$mobile_iphone_qr_code = $upload->get_position($image_info);
				$data =  array(
					'value'  => $mobile_iphone_qr_code
				);
				ecjia_config::instance()->write_config('mobile_iphone_qr_code', $mobile_iphone_qr_code);
			}
		}
		/* android二维码上传*/
		if (isset($_FILES['mobile_android_qr_code'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'auto_sub_dirs' => false));
			$upload->add_filename_callback(function () { return 'mobile_android_qr_code';});
			
			$image_info = $upload->upload($_FILES['mobile_android_qr_code']);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$mobile_android_qr_code = $upload->get_position($image_info);
				$data =  array(
					'value'  => $mobile_android_qr_code
				);
				ecjia_config::instance()->write_config('mobile_android_qr_code', $mobile_android_qr_code);
			}
		}
		/* ipad二维码上传*/
		if (isset($_FILES['mobile_ipad_qr_code'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'auto_sub_dirs' => false));
			$upload->add_filename_callback(function () { return 'mobile_ipad_qr_code';});
			
			$image_info = $upload->upload($_FILES['mobile_ipad_qr_code']);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$mobile_ipad_qr_code = $upload->get_position($image_info);
				$data =  array(
					'value'  => $mobile_ipad_qr_code
				);
				ecjia_config::instance()->write_config('mobile_ipad_qr_code', $mobile_ipad_qr_code);
			}
		}
		
		if (isset($_FILES['mobile_pad_login_bgimage'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'auto_sub_dirs' => false));
			$upload->add_filename_callback(function () { return 'mobile_pad_login_bgimage';});
			
			$mobile_pad_login_bgimage_info = $upload->upload($_FILES['mobile_pad_login_bgimage']);
			/* 判断是否上传成功 */
			if (!empty($mobile_pad_login_bgimage_info)) {
				$mobile_pad_login_bgimage = $upload->get_position($mobile_pad_login_bgimage_info);
				ecjia_config::instance()->write_config('mobile_pad_login_bgimage', $mobile_pad_login_bgimage);
			}
		}
		
		if (isset($_FILES['mobile_phone_login_bgimage'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'auto_sub_dirs' => false));
			$upload->add_filename_callback(function () { return 'mobile_phone_login_bgimage';});
			
			$mobile_phone_login_bgimage_info = $upload->upload($_FILES['mobile_phone_login_bgimage']);
			/* 判断是否上传成功 */
			if (!empty($mobile_phone_login_bgimage_info)) {
				$mobile_phone_login_bgimage = $upload->get_position($mobile_phone_login_bgimage_info);
				ecjia_config::instance()->write_config('mobile_phone_login_bgimage', $mobile_phone_login_bgimage);
			}
		}
		
		/* 上传app logo图标*/
		if (isset($_FILES['mobile_app_icon'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'auto_sub_dirs' => false));
			$upload->add_filename_callback(function () { return 'mobile_app_icon';});
			
			$mobile_app_icon_info = $upload->upload($_FILES['mobile_app_icon']);
			if (!empty($mobile_app_icon_info)) {
				$mobile_app_icon = $upload->get_position($mobile_app_icon_info);
				ecjia_config::instance()->write_config('shop_app_icon', $mobile_app_icon);
			}
		}
		
		/* 上传touch logo图标*/
		if (isset($_FILES['wap_logo'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'auto_sub_dirs' => false));
			$upload->add_filename_callback(function () { return 'wap_logo';});
			
			$wap_logo = $upload->upload($_FILES['wap_logo']);
			if (!empty($wap_logo)) {
				$wap_logo_icon = $upload->get_position($wap_logo);
				ecjia_config::instance()->write_config('wap_logo', $wap_logo_icon);
			}
		}
		ecjia_config::instance()->write_config('mobile_home_adsense_group', $mobile_home_adsense_group);
		
		$mobile_tv_adsense_group = array('big_group' => $mobile_tv_big_adsense, 'small_group' => $mobile_tv_small_adsense);
		ecjia_config::instance()->write_config('mobile_tv_adsense_group', serialize($mobile_tv_adsense_group));
		ecjia_config::instance()->write_config('mobile_launch_adsense', $mobile_launch_adsense);
		ecjia_config::instance()->write_config('mobile_recommend_city', $mobile_recommend_city);
		
		ecjia_config::instance()->write_config('mobile_pad_login_fgcolor', $mobile_pad_login_fgcolor);
		ecjia_config::instance()->write_config('mobile_pad_login_bgcolor', $mobile_pad_login_bgcolor);
		ecjia_config::instance()->write_config('mobile_phone_login_fgcolor', $mobile_phone_login_fgcolor);
		ecjia_config::instance()->write_config('mobile_phone_login_bgcolor', $mobile_phone_login_bgcolor);
		ecjia_config::instance()->write_config('mobile_feedback_autoreply', $mobile_feedback_autoreply);
		
		$bonus_readme_url = RC_Uri::url('article/mobile/info', 'id='.$bonus_readme);
		ecjia_config::instance()->write_config('bonus_readme_url', $bonus_readme_url);
		ecjia_config::instance()->write_config('mobile_topic_adsense', $mobile_topic_adsense);
		ecjia_config::instance()->write_config('mobile_shopkeeper_urlscheme', $mobile_shopkeeper_urlscheme);
		ecjia_config::instance()->write_config('mobile_shop_urlscheme', $mobile_shop_urlscheme);
		ecjia_config::instance()->write_config('shop_app_description', $shop_app_description);
		ecjia_config::instance()->write_config('shop_iphone_download', $shop_iphone_download);
		ecjia_config::instance()->write_config('shop_android_download', $shop_android_download);
		ecjia_config::instance()->write_config('shop_ipad_download', $shop_ipad_download);
		ecjia_config::instance()->write_config('shop_pc_url', $shop_pc_url);
		ecjia_config::instance()->write_config('shop_touch_url', $shop_touch_url);
		ecjia_config::instance()->write_config('wap_config', $wap_config);
		
		/* 签到送活动*/
		$checkin_award_open = isset($_POST['checkin_award_open']) ? intval($_POST['checkin_award_open']) : 0;
		$checkin_award_type = isset($_POST['checkin_award_type']) ? trim($_POST['checkin_award_type']) : 'integral';
		$checkin_award = !empty($_POST['checkin_award']) ? intval($_POST['checkin_award']) : 0;
		$checkin_extra_day = !empty($_POST['checkin_extra_day']) ? intval($_POST['checkin_extra_day']) : 0;
		$checkin_extra_award = !empty($_POST['checkin_extra_award']) ? intval($_POST['checkin_extra_award']) : 0;
// 		if ($checkin_extra_day > 0 ) {
			$checkin_extra_award_value = serialize(array('day' => $checkin_extra_day, 'extra_award' => $checkin_extra_award));
// 		}
		
		ecjia_config::instance()->write_config('checkin_award_open', $checkin_award_open);
		ecjia_config::instance()->write_config('checkin_award_type', $checkin_award_type);
		ecjia_config::instance()->write_config('checkin_award', $checkin_award);
		ecjia_config::instance()->write_config('checkin_extra_award', $checkin_extra_award_value);
		
		/* 评论送活动*/
		$comment_award_open = isset($_POST['comment_award_open']) ? intval($_POST['comment_award_open']) : 0;
		$comment_award = isset($_POST['comment_award']) ? intval($_POST['comment_award']) : 0;
		ecjia_config::instance()->write_config('comment_award_open', $comment_award_open);
		ecjia_config::instance()->write_config('comment_award', $comment_award);
		
		
		$comment_award_rules = '';
		if (isset($_POST['comment_award_rules'])) {
			foreach ($_POST['comment_award_rules'] as $key => $val) {
				if (empty($val)) {
					continue;
				}
				$comment_award_rules[$key] = intval($val);
			}
			if (!empty($comment_award_rules)) {
				$comment_award_rules = serialize($comment_award_rules);
			}
		}
		ecjia_config::instance()->write_config('comment_award_rules', $comment_award_rules);
		$order_reminder_type = intval($_POST['order_reminder_type']);
		ecjia_config::instance()->write_config('order_reminder_type', $order_reminder_type);
		if ($order_reminder_type == 1) {
			$order_reminder_value = intval($_POST['order_reminder_push']);
		} elseif($order_reminder_type == 2) {
			$order_reminder_value = trim($_POST['order_reminder_mobile']);
		} else {
			$order_reminder_value = '';
		}
		ecjia_config::instance()->write_config('order_reminder_value', $order_reminder_value);
		
		/*推荐*/
		$recommend_notice			= $_POST['recommend_notice'];
		$share_notice				= $_POST['share_notice'];
		ecjia_config::instance()->write_config('recommend_notice', $recommend_notice);
		ecjia_config::instance()->write_config('share_notice', $share_notice);
		
		ecjia_admin::admin_log(RC_Lang::get('mobile::mobile.mobile_config_set'), 'setup', 'mobile_config');
		$this->showmessage(RC_Lang::get('mobile::mobile.update_config_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_config/init')));

	}
	
	/**
	 * 删除上传文件
	 */
	public function del() {
		$this->admin_priv('mobile_config_delete', ecjia::MSGTYPE_JSON);
		
		$code     = trim($_GET['code']);
//		$img_name = $this->db_config->where(array('code'=>$code))->get_field('value');
		$img_name = RC_DB::table('shop_config')->where('code', $code)->pluck('value');

// 		@unlink(RC_Upload::upload_path() . $img_name);
		$disk = RC_Filesystem::disk();
		$disk->delete(RC_Upload::upload_path() . $img_name);
		
		ecjia_admin::admin_log('', 'edit', 'mobile_config');
		ecjia_config::instance()->write_config($code, '');		
		$this->showmessage(RC_Lang::get('mobile::mobile.del_ok') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	public function search_article() {
		$result = RC_Api::api('article', 'article_list', array('keywords' => $_POST['artile']));
		$list = array();
		if (!empty($result['arr'])) {
			foreach ($result['arr'] as $val) {
				$list[] = array(
					'id' 	=> $val['article_id'],
					'name' 	=> $val['title']
				);
			}
		}
		$this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $list));
	}

	private function get_regions($type = 0, $parent = 0) {
		return RC_DB::table('region')->where('region_type', $type)->where('parent_id', $parent)->select('region_id', 'region_name')->get();
	}
}

//end