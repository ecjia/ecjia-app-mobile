<?php
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_device_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->db_config = RC_Config::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'mobile_device';
		parent::__construct();
	}
	
	/**
	 * 取得设备列表
	 *
	 * @return  array
	 */
	public function device_list($option) {
		return $this->where($option['where'])->order($option['order'])->limit($option['limit'])->select();
	}
	
	public function device_update($id, $data, $in=false) {
		if ($in) {
			return $this->in(array('id' => $id))->update($data);
		}
		return $this->where(array('id' => $id))->update($data);
	}
	
	public function device_find($id, $field='*') {
		return $this->where(array('id' => $id))->field($field)->find();
	}
	
	public function device_delete($where, $in=false) {
		if ($in) {
			return $this->in($where)->delete();
		}
		return $this->where($where)->delete();
	}
	
	public function device_select($where, $in=false) {
		if ($in) {
			return $this->in($where)->select();
		}
		return $this->where($where)->select();
	}
	
	public function device_count($where) {
		return $this->where($where)->count();
	}
}

// end