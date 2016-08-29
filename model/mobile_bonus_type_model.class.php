<?php
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_bonus_type_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->db_config = RC_Config::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'bonus_type';
		parent::__construct();
	}
	
	public function bonus_type_select($where=array(), $field='*') {
		return $this->where($where)->field($field)->select();
	}
}

// end