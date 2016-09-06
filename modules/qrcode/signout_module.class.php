<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 二维码登录验证解绑
 * @author will.chen
 *
 */
class signout_module extends api_front implements api_interface {

	 public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$this->authSession();
    	
		$code = $this->requestdata('code');
		if (empty($code)) {
			EM_Api::outPut(101);
		}
		$db = RC_Loader::load_app_model('qrcode_validate_model', 'mobile');
		$where = array(
				'session_id' => RC_Session::session()->get_session_id(),
				'uuid'		 => $code,
				'status'	 => 1,
				'expires_in' => array('gt' => RC_Time::gmtime()), 
		);
		
		$result = $db->where($where)->update(array('status' => 3));
		return array();
	}
}

// end