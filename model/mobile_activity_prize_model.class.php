<?php
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_activity_prize_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->db_config = RC_Config::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'mobile_activity_prize';
		parent::__construct();
	}
	
	public function activity_prize_select($where=array(), $order=array()) {
		return $this->where($where)->order($order)->select();
	}
	
	public function activity_prize_field($where, $field, $bool=false) {
		return $this->where($where)->get_field($field, $bool);
	}
	
	public function activity_prize_remove($where, $in=false) {
		if ($in) {
			return $this->in($where)->delete();
		}
		return $this->where($where)->delete();
	}
	
	public function activity_prize_manage($data, $where=array()) {
		if (!empty($where)) {
			return $this->where($where)->update($data);
		}
		return $this->insert($data);
	}
}

// end