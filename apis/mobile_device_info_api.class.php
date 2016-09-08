<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 获取移动设置device info
 * @author royalwang
 *
 */
class mobile_device_info_api extends Component_Event_Api {
	
    /**
     * @param $options[array] 
     *          $options['user_id'] 用户ID
     *          $options['admin_id'] 管理员ID
     *
     * @return array
     */
	public function call(&$options) {	
	    $user_id = isset($options['user_id']) ? $options['user_id'] : 0;
	    if (isset($options['admin_id'])) {
	        $user_id = $options['admin_id'];
	        $is_admin = 1;
	    } else {
	        $is_admin = 0;
	    }
	    
	    if (!empty($user_id)) {
	        $db = RC_Model::model('mobile/mobile_device_model');
	        return $db->order(array('id' => 'DESC'))->find(array('user_id' => $user_id, 'is_admin' => $is_admin,  'device_code' => $options['device_code']));
	    }
        
	}
}

// end