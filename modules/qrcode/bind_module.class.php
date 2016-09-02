<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 二维码登录验证绑定
 * @author will.chen
 *
 */
class bind_module extends api_front implements api_interface {

	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authSession();
    	
		$code = $this->requestdata('code');
		$device = $this->requestdata('device', array());
		$type = $this->requestdata('type');
		if (empty($code) || empty($type)) {
			EM_Api::outPut(101);
		}
		//判断是管理员还是普通用户
		$is_admin = in_array($device['code'], array('8001', '5001', '5002', '2001', '2002')) ? 1 : 0;
		$db = RC_Loader::load_app_model('qrcode_validate_model', 'mobile');
		$where = array(
				'is_admin'   => $is_admin,
				'uuid'		 => $code,
				'status'	 => 1,
				'expires_in' => array('gt' => RC_Time::gmtime()), 
		);
		$result = $db->find($where);
		if (empty($result)) {
			return EM_Api::outPut(8);
		}
		//判断是管理员还是普通用户
		$user_id = $is_admin == 1 ? $_SESSION['admin_id'] : $_SESSION['user_id'];
		//判断是授权还是取消
		$status = $type == 'bind' ? 2 : 3;
		$result = $db->where($where)->update(array('status' => $status, 'user_id' => $user_id));
		return array();
	}
}

// end