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
//		return $this->where($option['where'])->order($option['order'])->limit($option['limit'])->select();
		$db_mobile_activity = RC_DB::table('mobile_activity');
		$where = $option['where'];
		$order = $option['add_time'];
		$limit = $option['take'];
		$skip = $option['skip'];
		if (!empty($where)) {
			foreach ($where as $key => $val) {
				if (is_array($val)) {
					foreach ($val as $k => $v){
						if ($k == 'like') {
							$db_mobile_activity->where($key, $v);
						}
					}
				} else {
					$db_mobile_activity->where($key, $val);
				}
			}
		}
		return $db_mobile_activity->orderby('add_time', $order)->take($limit)->skip($skip)->get();
	}
	
	public function activity_count($where) {
//		return $this->where($where)->count();
		$db_mobile_activity = RC_DB::table('mobile_activity');
		if (is_array($where)) {
			foreach ($where as $key => $val) {
				if (is_array($val)) {
					foreach ($val as $k => $v) {
						if ($k == 'neq') {
							$db_mobile_activity->where($key, '!=', $v);
						}
					}
				} else {
					$db_mobile_activity->where($key, $val);
				}
			}
		}
		return $db_mobile_activity->count();

	}
	
	public function mobile_activity_manage($parameter) {
//		if (!isset($parameter['activity_id'])) {
//			$id = $this->insert($parameter);
//		} else {
//			$where = array('activity_id' => $parameter['activity_id']);
//
//			$this->where($where)->update($parameter);
//			$id = $parameter['activity_id'];
//		}
//		return $id;
		if (!isset($parameter['activity_id'])) {
			$id =  RC_DB::table('mobile_activity')->insertGetId($parameter);
		} else {
			RC_DB::table('mobile_activity')->where('activity_id', $parameter['activity_id'])->update($parameter);
			$id = $parameter['activity_id'];
		}
		return $id;
	}
	
	public function mobile_activity_find($id) {
//		return $this->where(array('activity_id' => $id))->find();
		return RC_DB::table('mobile_activity')->where('activity_id', $id)->first();
	}
	
	public function mobile_activity_field($where, $field) {
//		return $this->where($where)->get_field($field);
		return RC_DB::table('mobile_activity')->where('activity_id', $where)->pluck($field);
	}
	
	public function mobile_activity_remove($where) {
//		return $this->where($where)->delete();
		return RC_DB::table('mobile_activity')->where('activity_id', $where)->delete();
	}
}

// end