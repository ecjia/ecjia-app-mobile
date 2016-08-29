<?php
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_activity_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->db_config = RC_Config::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'mobile_activity';
		parent::__construct();
	}
	
	/**
	 * 获取活动列表
	 * @return array
	 */
	public function activity_list($option) {
		return $this->where($option['where'])->order($option['order'])->limit($option['limit'])->select();
	}
	
	public function activity_count($where) {
		return $this->where($where)->count();
	}
	
	public function mobile_activity_manage($parameter) {
		if (!isset($parameter['activity_id'])) {
			$id = $this->insert($parameter);
		} else {
			$where = array('activity_id' => $parameter['activity_id']);
	
			$this->where($where)->update($parameter);
			$id = $parameter['activity_id'];
		}
		return $id;
	}
	
	public function mobile_activity_find($id) {
		return $this->where(array('activity_id' => $id))->find();
	}
	
	public function mobile_activity_field($where, $field) {
		return $this->where($where)->get_field($field);
	}
	
	public function mobile_activity_remove($where) {
		return $this->where($where)->delete();
	}
}

// end