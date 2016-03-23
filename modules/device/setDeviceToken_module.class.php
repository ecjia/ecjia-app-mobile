<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 
 * @author royalwang
 *
 */
class setDeviceToken_module implements ecjia_interface {

	public function run(ecjia_api & $api) {
		
		$device = _POST('device', array());
		
		$device['device_token'] = _POST('device_token');
		
		if (empty($device['udid']) || empty($device['client']) || empty($device['code']) || empty($device['device_token'])) {
			EM_Api::outPut(101);
		}
		
		$db_mobile_device = RC_Loader::load_app_model('mobile_device_model', 'mobile');
		$device_data = array(
				'device_udid'	=> $device['udid'],
				'device_client'	=> $device['client'],
				'device_code'	=> $device['code']
		);
		$row = $db_mobile_device->find($device_data);
		
		if (empty($row)) {
			$device_data['add_time'] = RC_Time::gmtime();
			$device_data['device_token'] = !empty($device['device_token']) ? $device['device_token'] : '';
				
			$db_mobile_device->insert($device_data);
		} else {
			$data = array();
			if (!empty($device['device_token'])) {
				$data['device_token'] = $device['device_token'];
			}
			$db_mobile_device->where($device_data)->update($data);
		}
		return array();
		
	}
}

// end