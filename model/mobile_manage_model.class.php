<?php
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_manage_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->db_config = RC_Config::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'mobile_manage';
		parent::__construct();
	}
	
	public function mobile_manage($parameter) {
// 		if (!isset($parameter['app_id'])) {
// 			$id = $this->insert($parameter);
// 		} else {
// 			$where = array('app_id' => $parameter['app_id']);
	
// 			$this->where($where)->update($parameter);
// 			$id = $parameter['app_id'];
// 		}
// 		return $id;
		$db_mobile_manage = RC_DB::table('mobile_manage');
		if (!isset($parameter['app_id'])) {
			$id = $db_mobile_manage->insertGetid($parameter);
		} else {
			$where = array('app_id' => $parameter['app_id']);
			$db_mobile_manage->where($where)->update($parameter);
			$id = $parameter['app_id'];
		}
		return $id;
	}
	
	public function mobile_manage_find($id) {
// 		return $this->where(array('app_id' => $id))->find();
		RC_DB::table('mobile_manage')->where('app_id', $id)->select();
	}
	
	public function mobile_manage_count() {
// 		return $this->count();
		return RC_DB::table('mobile_manage')->count();
	}
	
	public function mobile_manage_list($option) {
		return $this->limit($option['limit'])->order($option['order'])->select();
// 		return RC_DB::table('mobile_manage')->take($page->limit())->orderBy('sort', 'desc')->
	}
}

// end