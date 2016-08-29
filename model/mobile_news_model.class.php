<?php
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_news_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->db_config = RC_Config::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'mobile_news';
		parent::__construct();
	}

	public function mobile_news_manage($data, $where=array()) {
		if (!empty($where)) {
			return $this->where($where)->update($data);
		}
		return $this->insert($data);
	}
	
	public function mobile_news_select($where=array(), $order=array()) {
		if (!empty($order)) {
			return $this->where($where)->order($order)->select();
		}
		return $this->where($where)->select();
	}
	
	public function mobile_news_field($where, $field, $bool=false) {
		return $this->where($where)->get_field($field, $bool);
	}
	
	public function mobile_news_delete($where) {
		return $this->where($where)->delete();
	}
	
	public function mobile_news_count($where) {
		return $this->where($where)->count();
	}
	
	public function mobile_news_list($option) {
		return $this->where($option['where'])->limit($option['limit'])->order($option['order'])->select();
	}
}

// end