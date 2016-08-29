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
		if (!isset($parameter['app_id'])) {
			$id = $this->insert($parameter);
		} else {
			$where = array('app_id' => $parameter['app_id']);
	
			$this->where($where)->update($parameter);
			$id = $parameter['app_id'];
		}
		return $id;
	}
	
	public function mobile_manage_find($id) {
		return $this->where(array('app_id' => $id))->find();
	}
	
	public function mobile_manage_count() {
		return $this->count();
	}
	
	public function mobile_manage_list($option) {
		return $this->limit($option['limit'])->order($option['order'])->select();
	}
}

// end