<?php
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_toutiao_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->db_config = RC_Config::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'mobile_toutiao';
		parent::__construct();
	}
	
	public function toutiao_count($where) {
		return $this->where($where)->count();
	}
	
	public function toutiao_list($option) {
		return $this->where($option['where'])->order($option['order'])->limit($option['limit'])->select();
	}

	public function toutiao_manage($parameter) {
		if (!isset($parameter['id'])) {
			$id = $this->insert($parameter);
		} else {
			$where = array('id' => $parameter['id']);
	
			$this->where($where)->update($parameter);
			$id = $parameter['id'];
		}
		return $id;
	}
	
	public function toutiao_find($id) {
		return $this->where(array('id' => $id))->find();
	}
	
	public function toutiao_remove($id) {
		return $this->where(array('id' => $id))->delete();
	}
	
	public function toutiao_batch($where, $type) {
		if ($type == 'select') {
			return $this->in($where)->select();
		} elseif ($type == 'delete') {
			return $this->in($where)->delete();
		}
	}
}

// end