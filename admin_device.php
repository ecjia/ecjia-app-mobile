<?php
/**
 * ECJIA 移动设备管理
*/
defined('IN_ECJIA') or exit('No permission resources.');

class admin_device extends ecjia_admin {
	private $db_device;
	
	public function __construct() {
		parent::__construct();
// 		RC_Lang::load('device');

		/* 数据模型加载 */
		$this->db_device = RC_Loader::load_app_model('mobile_device_model');
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
		RC_Style::enqueue_style('bootstrap-editable',       RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
		RC_Script::enqueue_script('media-editor', RC_Uri::vendor_url('tinymce/tinymce.min.js'), array(), false, true);
		
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('device', RC_App::apps_url('statics/js/device.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_device'), RC_Uri::url('mobile/admin_device/init')));
	}
	
	/**
	 * 移动设备列表
	 */
	public function init() {
		$this->admin_priv('device_manage', ecjia::MSGTYPE_JSON);
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.mobile_device_list'));
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_device')));
		
		$device_list = $this->get_devicelist();
		$this->assign('device_list', $device_list);
		$this->assign('search_action', RC_Uri::url('mobile/admin_device/init'));
				
// 		$this->assign_lang();
		$this->display('device_list.dwt');
	}

	/**
	 * 移至回收站
	 */
	public function trash()  {
		$this->admin_priv('device_update', ecjia::MSGTYPE_JSON);
	
		$id = intval($_GET['id']);
		$deviceval = intval($_GET['deviceval']);
		$success = $this->db_device->where(array('id' => $id))->update(array('in_status' => 1));
		
		$info = $this->db_device->where(array('id' => $id))->find();
		$info['device_client'] = ucfirst($info['device_client']);
		
		ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $info['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $info['device_name']), 'trash', 'mobile_device');
		if ($success){
			$this->showmessage(RC_Lang::get('mobile::mobile.trash_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_device/init', array('deviceval' => $deviceval))));
		} else {
			$this->showmessage(RC_Lang::get('mobile::mobile.trash_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 从回收站还原
	 */
	public function returndevice()  {
		$this->admin_priv('device_update',ecjia::MSGTYPE_JSON);
	
		$id = intval($_GET['id']);
		$success = $this->db_device->where(array('id' => $id))->update(array('in_status' => 0));
		
		$info = $this->db_device->where(array('id' => $id))->find();
		$info['device_client'] = ucfirst($info['device_client']);
		
		ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $info['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $info['device_name']), 'restore', 'mobile_device');
		if ($success){
			$this->showmessage(RC_Lang::get('mobile::mobile.restore_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			$this->showmessage(RC_Lang::get('mobile::mobile.restore_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 删除移动设备
	 */
	public function remove()  {
		$this->admin_priv('device_delete',ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		$deviceval = intval($_GET['deviceval']);
		
		$info = $this->db_device->where(array('id' => $id))->find();
		$info['device_client'] = ucfirst($info['device_client']);
		
		$success = $this->db_device->where(array('id' => $id))->delete();
		ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $info['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $info['device_name']), 'remove', 'mobile_device');
		if ($success){
			$this->showmessage(RC_Lang::get('mobile::mobile.del_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_device/init', array('deviceval' => $deviceval))));
		} else {
			$this->showmessage(RC_Lang::get('mobile::mobile.del_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 批量删除设备
	 */
	public function batch(){
		$action    = trim ($_GET['sel_action']);
		$deviceval = intval($_GET['deviceval']);
		
		if ($action == 'del') {
			$this->admin_priv('device_delete', ecjia::MSGTYPE_JSON);
		} else {
			$this->admin_priv('device_update', ecjia::MSGTYPE_JSON);
		}
		$info = $this->db_device->in(array('id' => $_POST['id']))->select();
		
		foreach ($info as $k => $rows) {
			$info[$k]['device_client'] = ucfirst($rows['device_client']);
		}
		
		switch ($action) {
			case 'trash':
				$data = array(
					'in_status' => 1
				);
				$this->db_device->in(array('id' => $_POST['id']))->update($data);
				
				foreach ($info as $v) {
					ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $v['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $v['device_name']), 'batch_trash', 'mobile_device');
				}
				break;
				
			case 'returndevice':
				$data = array(
					'in_status' => 0
				);
				$this->db_device->in(array('id' => $_POST['id']))->update($data);
				
				foreach ($info as $v) {
					ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $v['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $v['device_name']), 'batch_restore', 'mobile_device');
				}
				break;
					
			case 'del':
				$this->db_device->in(array('id' => $_POST['id']))->delete();
				foreach ($info as $v) {
					ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $v['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $v['device_name']), 'batch_remove', 'mobile_device');
				}
				break;
				
			default :
				break;
		}
		$this->showmessage(RC_Lang::get('mobile::mobile.batch_handle_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_device/init', array('deviceval' => $deviceval))));
	}
	
	/**
	 * 预览
	 */
	public function preview() {
		$this->admin_priv('device_detail',ecjia::MSGTYPE_JSON);
	
		$id = intval($_GET['id']);
	
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.view_device_info'));
		$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.mobile_device_list'), 'href' => RC_Uri::url('mobile/admin_device/init')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.view_device_info')));

		$device = $this->db_device->find(array('id' => $id));
		$device['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $device['add_time']);
		$device['device_client'] = ucfirst($device['device_client']);
		
		$this->assign('device', $device);

// 		$this->assign_lang();
		$this->display('preview.dwt');
	}
	
	/**
	 * 编辑设备别名
	 */
	public function edit_device_alias() {
		$this->admin_priv('device_update',ecjia::MSGTYPE_JSON);
	
		$id = intval($_POST['pk']);
		$device_alias = !empty($_POST['value']) ? trim($_POST['value']) : '';
		if (empty($device_alias)) {
			$this->showmessage(RC_Lang::get('mobile::mobile.device_alias_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$query = $this->db_device->where(array('id' => $id))->update( array('device_alias' => $device_alias) );
		if ($query) {
			$info = $this->db_device->where(array('id' => $id))->find();
			$info['device_client'] = ucfirst($info['device_client']);

			ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $info['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $info['device_udid']).'，'.sprintf(RC_Lang::get('mobile::mobile.edit_device_alias_as'), $device_alias), 'setup', 'mobile_device');
			$this->showmessage(RC_Lang::get('mobile::mobile.edit_device_alias_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			$this->showmessage(RC_Lang::get('mobile::mobile.edit_device_alias_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 取得设备列表
	 *
	 * @return  array
	 */
	private function get_devicelist() {

		$db_device = RC_Loader::load_app_model('mobile_device_model');
		$filter = array();
		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		$filter['deviceval']= empty($_GET['deviceval']) ? 0 : intval($_GET['deviceval']);
		
		if ($filter['keywords']) {
			$where[]= "device_name LIKE '%" . mysql_like_quote($filter['keywords']) . "%'";
		}
		
		if ($filter['deviceval'] == 0) {
			$where['in_status'] = 0;
		}
		
		$android = 'android';
		if ($filter['deviceval'] == 1) {
			$where[] ="device_client = '" .$android. "' and device_code != 8001 and in_status = 0";
		}
		
		$iphone = 'iphone';
		if ($filter['deviceval'] == 2) {
			$where[] = "device_client = '" .$iphone. "' and in_status = 0";
		}
		
		$ipad = 'ipad';
		if ($filter['deviceval'] == 3) {
			$where[] = "device_client = '" .$ipad. "' and in_status = 0";
		}
		
		$cashier = 'android';
		if ($filter['deviceval'] == 4) {
			$where[] = "device_client = '" .$cashier. "' and device_code = 8001 and in_status = 0";
		}
		
		if ($filter['deviceval'] == 5) {
			$where['in_status'] = 1;
		}
	
		$field = "SUM(IF(in_status=0,1,0)) AS count, SUM(IF(device_client='android' and device_code !='8001' and in_status = 0,1,0)) AS android, SUM(IF(device_client='iphone' and in_status = 0,1,0)) AS iphone, SUM(IF(device_client='ipad' and in_status = 0,1,0)) AS ipad, SUM(IF(device_client='android' and device_code='8001' and in_status = 0,1,0)) AS cashier, SUM(IF(in_status = 1,1,0)) AS trashed";
		$msg_count = $db_device->field($field)->find();
		$msg_count = array(
			'count'		=> empty($msg_count['count']) 	? 0 : $msg_count['count'],
			'android'	=> empty($msg_count['android']) ? 0 : $msg_count['android'],
			'iphone'	=> empty($msg_count['iphone']) 	? 0 : $msg_count['iphone'],
			'ipad'	    => empty($msg_count['ipad']) 	? 0 : $msg_count['ipad'],
			'cashier'	=> empty($msg_count['cashier']) ? 0 : $msg_count['cashier'],
			'trashed'	=> empty($msg_count['trashed']) ? 0 : $msg_count['trashed']
		);
		
		$count = $db_device->where($where)->count();
		$page = new ecjia_page($count, 10, 5);
	
		$arr = array();
		$data = $db_device->where($where)->order ('id DESC')->limit($page->limit())->select();
		if (isset($data)) {
			foreach ($data as $rows) {
				$rows['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
				$rows['device_client'] = ucfirst($rows['device_client']);
				$arr[] = $rows;
			}
		}
		return array('device_list' => $arr, 'filter' => $filter, 'page' => $page->show (5), 'desc' => $page->page_desc(), 'msg_count' => $msg_count);	
	}
}
// end