<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 
 * @author will
 *
 */
class message_module implements ecjia_interface {
	
	public function run(ecjia_api & $api) {
		
		$ecjia = RC_Loader::load_app_class('api_admin', 'api');
		$ecjia->authadminSession();
		
		$mobile_messages_db = RC_Loader::load_app_model('mobile_message_model', 'mobile');
		$db_orderinfo_view = RC_Loader::load_app_model('order_info_viewmodel', 'orders');
		
		$db_orderinfo_view->view = array(
				'order_info' => array(
						'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'	=> 'oii',
						'on'	=> 'oi.order_id = oii.main_order_id'
				),
				'order_goods' => array(
						'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'	=> 'og',
						'on'	=> 'oi.order_id = og.order_id'
				)
		);
		$where = array();
		/* 判断是否是入驻商*/
		if (isset($_SESSION['ru_id']) && $_SESSION['ru_id'] > 0) {
			/*入驻商*/
			$where['ru_id'] = $_SESSION['ru_id'];
			$where[] = 'oii.order_id is null';
			$join = array('order_info', 'order_goods');
		} else {
			/*自营*/
			$where['oi.main_order_id'] = 0;
			$join = null;
		}
		
		/* 获取最后一条订单信息记录*/
		$order_message = $mobile_messages_db->order(array('message_id' => 'desc'))->find(array('message_type' => 'orders', 'sender_id' => -101, 'receiver_id' => $_SESSION['admin_id'], 'receiver_admin' => 1));
		
		$order_info_msg = unserialize($order_message['message']);
		$data = array();
		$parameter = explode('&', end(explode('?', $order_info_msg['url'])));
		if (!empty($parameter)) {
			foreach ($parameter as $val) {
				$tmp = explode('=',$val);
				$data[$tmp[0]] = $tmp[1];
			}
		}
		if (!empty($data) && $data['order_id'] > 0) {
			$where['oi.order_id'] = array('gt' => $data['order_id']);
		}
		
		$order_result = $db_orderinfo_view->field('oi.order_id, add_time, (oi.goods_amount - oi.discount + oi.tax + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee) AS total_fee')->join($join)->where(array_merge(array('oi.order_status' => array('lt' => 2)), $where))->order(array('oi.order_id' => 'asc'))->select();
		
		if (!empty($order_result)) {
			foreach ($order_result as $key => $val) {
				$message = array(
						'url' => 'ecjiaopen://app?open_type=orders_detail&order_id='.$val['order_id'], 
						'message' => RC_Time::local_date(ecjia::config('time_format'), $val['add_time']).'分成交一份订单，订单号：'.$val['order_sn'].'，金额'.$val['total_fee']);
				$serialize_message = serialize($message);
				$data = array(
						'sender_id'		=> -101,//订单
						'sender_admin'	=> 1,
						'receiver_id'	=> $_SESSION['admin_id'],
						'receiver_admin' => 1,
						'send_time'		=> RC_Time::gmtime(),
						'message'		=> $serialize_message,
						'message_type'	=> 'orders',
				);
				$mobile_messages_db->insert($data);
			}
		}
		
		$count = $mobile_messages_db->where(array('message_type' => 'orders', 'sender_id' => -101, 'receiver_id' => $_SESSION['admin_id'], 'receiver_admin' => 1))->count();
		/* 查询总数为0时直接返回  */
		if ($count == 0) {
			$pager = array(
					'total' => 0,
					'count' => 0,
					'more'	=> 0,
			);
			EM_Api::outPut(array(), $pager);
		}
		
		/* 获取数量 */
		$size = EM_Api::$pagination['count'];
		$page = EM_Api::$pagination['page'];
		
		//加载分页类
		RC_Loader::load_sys_class('ecjia_page', false);
		//实例化分页
		$page_row = new ecjia_page($count, $size, 6, '', $page);
		
		$message_result = $mobile_messages_db->where(array('receiver_admin' => 1, 'deleted' => 0, 'receiver_id' => $_SESSION['admin_id']))
							->order(array('message_id' => 'desc'))
							->limit($page_row->limit())	
							->select();
		$message_list = array();
		if (!empty($message_result)) {
			foreach ($message_result as $val) {
				$unserialize_message = unserialize($val['message']);
				$message_list[] = array(
					'message_id' => $val['message_id'],
					'message'	 => $unserialize_message['message'],
					'url'		 => $unserialize_message['url'],
					'type'		 => $val['message_type'],
					'time'		 => RC_Time::local_date(ecjia::config('time_format'), $val['send_time'])	
				);
			}
		}
		
		$pager = array(
				"total" => $page_row->total_records,
				"count" => $page_row->total_records,
				"more"	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		EM_Api::outPut($message_list, $pager);
		
	}
	
	
}


// end