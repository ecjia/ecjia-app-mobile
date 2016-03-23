<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 二维码登录验证绑定
 * @author will.chen
 *
 */
class signin_module implements ecjia_interface {

	public function run(ecjia_api & $api) {
		
		EM_Api::authSession();
		$code = _POST('code');
		if (empty($code)) {
			EM_Api::outPut(101);
		}
		$db = RC_Loader::load_app_model('qrcode_validate_model', 'mobile');
		$where = array(
				'session_id' => RC_Session::session_id(),
				'uuid'		 => $code,
				'status'	 => 1,
				'expires_in' => array('gt' => RC_Time::gmtime()), 
		);
		$result = $db->find($where);
		if (empty($result)) {
			return EM_Api::outPut(8);
		}
		$result = $db->where($where)->update(array('status' => 2));
		return array();
	}
}

// end