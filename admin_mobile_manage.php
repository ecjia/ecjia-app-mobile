<?php

/**
 * ECJIA移动应用配置模块
 */

defined('IN_ECJIA') or exit('No permission resources.');

class admin_mobile_manage extends ecjia_admin {
	
	private $db_mobile_manage;
	
	public function __construct() {
		parent::__construct();
		
		$this->db_mobile_manage = RC_Loader::load_app_model('mobile_manage_model');
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Style::enqueue_style('chosen');
		
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('smoke');
		
		RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
		
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		
		
		RC_Script::enqueue_script('mobile_manage', RC_App::apps_url('statics/js/mobile_manage.js' , __FILE__), array(), false, false);
		
		RC_Script::enqueue_script('bootstrap-placeholder');
		
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('客户端管理'), RC_Uri::url('mobile/admin_mobile_manage/init')));
		
		
	}

					
	/**
	 * 移动应用配置页面
	 */
	public function init () {
		$this->admin_priv('mobile_manage', ecjia::MSGTYPE_JSON);

		$count = $this->db_mobile_manage->count();
		$page = new ecjia_page ($count, 10, 5);
		$mobile_manage = $this->db_mobile_manage->limit($page->limit())->order(array('sort' => 'DESC'))->select();
		
		$mobile_client = array('iphone' => 'iPhone', 'ipad' => 'iPad', 'android' => 'Android');
		if (!empty($mobile_manage)) {
			foreach ($mobile_manage as $key => $val) {
				$mobile_manage[$key]['device_client'] = $mobile_client[$val['device_client']];
				$mobile_manage[$key]['add_time'] = RC_Time::local_date(ecjia::config('date_format'), $val['add_time']);
			}
		}
		
		
		$this->assign('mobile_manage', $mobile_manage);
		$this->assign('mobile_manage_page', $page->show(5));
		$this->assign('action_link', array('text' => __('添加客户端应用'), 'href' => RC_Uri::url('mobile/admin_mobile_manage/add')));
		ecjia_screen::$current_screen->remove_last_nav_here();
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('客户端管理')));
		$this->assign('ur_here', __('客户端管理'));
		
		$this->display('mobile_manage_list.dwt');
	}
		
	/**
	 * 添加移动应用配置
	 */
	public function add () {
		$this->admin_priv('mobile_manage_add', ecjia::MSGTYPE_JSON);
		
		$mobile_client = array('iphone' => 'iPhone', 'ipad' => 'iPad', 'android' => 'Android');
		$this->assign('action_link', array('text' => __('客户端管理'), 'href' => RC_Uri::url('mobile/admin_mobile_manage/init')));
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('添加客户端应用')));
		$this->assign('ur_here', __('添加客户端应用'));
		$this->assign('mobile_client', $mobile_client);
		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_manage/insert'));
		$this->display('mobile_manage_info.dwt');
	}
	
	public function insert() {
		$this->admin_priv('mobile_manage_add', ecjia::MSGTYPE_JSON);
		$name = trim($_POST['name']);
		$client = trim($_POST['client']);
		$code = trim($_POST['code']);
		$bundleid = trim($_POST['bundleid']);
		$appkey = trim($_POST['appkey']);
		$appsecret = trim($_POST['appsecret']);
		$platform = trim($_POST['platform']);
		$status = isset($_POST['status']) ? $_POST['status'] : 0;
		
		$data = array(
				'app_name'		=> $name,
				'device_client'	=> $client,
				'device_code'		=> $code,
				'bundle_id'	=> $bundleid,
				'app_key'	=> $appkey,
				'app_secret'	=> $appsecret,
				'platform'	=> $platform,
				'status'	=> $status,
				'add_time'	=> RC_Time::gmtime(),
				'sort'		=> intval($_POST['sort']),
		);
		$id = $this->db_mobile_manage->insert($data);
		
		ecjia_admin::admin_log($data['app_name'], 'add', 'mobile_manage');
		
		$links[] = array('text' => __('客户端管理'), 'href' => RC_Uri::url('mobile/admin_mobile_manage/init'));
		$this->showmessage('添加客户端应用成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links , 'pjaxurl' => RC_Uri::url('mobile/admin_mobile_manage/edit', 'id='.$id)));
		
	}
	
	/**
	 * 编辑显示页面
	 */
	public function edit() {
		$this->admin_priv('mobile_manage_update', ecjia::MSGTYPE_JSON);
		$mobile_manage = $this->db_mobile_manage->find(array('app_id' => intval($_GET['id'])));
		
		$mobile_client = array('iphone' => 'iPhone', 'ipad' => 'iPad', 'android' => 'Android');
		$this->assign('mobile_client', $mobile_client);
		$this->assign('mobile_manage', $mobile_manage);
		$this->assign('action_link', array('text' => __('客户端管理'), 'href' => RC_Uri::url('mobile/admin_mobile_manage/init')));
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('编辑客户端应用')));
		$this->assign('ur_here', __('编辑客户端应用'));
		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_manage/update'));
		$this->display('mobile_manage_info.dwt');
	
	
	}
	
	/**
	 * 执行修改
	 */
	public function update() {
		$this->admin_priv('mobile_manage_update', ecjia::MSGTYPE_JSON);
		$name = trim($_POST['name']);
		$client = trim($_POST['client']);
		$bundleid = trim($_POST['bundleid']);
		$appkey = trim($_POST['appkey']);
		$appsecret = trim($_POST['appsecret']);
		$platform = trim($_POST['platform']);
		$status = isset($_POST['status']) ? $_POST['status'] : 0;
		$id = intval($_POST['id']);
		$data = array(
				'app_name'		=> $name,
				'device_client'	=> $client,
				'bundle_id'	=> $bundleid,
				'app_key'	=> $appkey,
				'app_secret'	=> $appsecret,
				'platform'	=> $platform,
				'status'	=> $status,
				'add_time'	=> RC_Time::gmtime(),
				'sort'		=> intval($_POST['sort']),
		);
		$this->db_mobile_manage->where(array('app_id' => $id))->update($data);
		ecjia_admin::admin_log($data['app_name'], 'edit', 'mobile_manage');
		
		
		$this->showmessage('修改客户端应用成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_manage/edit', 'id='.$id)));
		
		
	}
	
	/**
	 * 删除
	 */
	public function remove() {
		$this->admin_priv('mobile_manage_delete', ecjia::MSGTYPE_JSON);
		$name = $this->db_mobile_manage->where(array('app_id' => intval($_GET['id'])))->get_field('app_name');
		$this->db_mobile_manage->delete(array('app_id' => intval($_GET['id'])));
		
		ecjia_admin::admin_log($name, 'remove', 'mobile_manage');
		$this->showmessage('删除客户端应用成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_manage/init')));
		
	}
	
	/**
	 * 排序
	 */
	public function edit_sort() {
		$this->admin_priv('mobile_manage_update', ecjia::MSGTYPE_JSON);
		$id = intval($_POST['pk']);
		$sort_order = intval($_POST['value']);
		$data = array(
				'sort' => $sort_order,
		);
		$name = $this->db_mobile_manage->where(array('app_id' => $id))->get_field('app_name');
		$this->db_mobile_manage->where(array('app_id' => $id))->update($data);
		ecjia_admin::admin_log($name, 'edit', 'mobile_manage');
		
		$this->showmessage(__('客户端排序修改成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('mobile/admin_mobile_manage/init')));
		
	}
	
	

}

//end