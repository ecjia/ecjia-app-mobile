<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 
 * @author will
 *
 */
class data_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
		$this->authadminSession();
		$ecjia = RC_Loader::load_app_class('api_admin', 'api');
		
		$stats_db = RC_Model::model('stats/stats_model');
// 		$order_db = RC_Model::model('orders/order_info_model');
		$db_orderinfo_view = RC_Model::model('orders/order_info_viewmodel');
		
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
		
		
		$today = RC_Time::local_getdate();
		
		$today_time = RC_Time::local_mktime(0, 0, 0, $today['mon'], $today['mday'], $today['year']);//今日开始时间
		
		$yesterday_time = $today_time - 3600 * 24;//昨日开始时间
		
		/* 分组统计订单数和销售额：已发货时间为准 */
// 		$order_count_where = array();
// 		$order_count_where[] = "(oi.order_status = '" . OS_CONFIRMED . "' OR oi.order_status >= '" . OS_SPLITED . "')";
		$order_amount_where = array();
		$order_amount_where[] = "(oi.pay_status = '" . PS_PAYED . "' OR oi.pay_status = '" . PS_PAYING . "')";
// 		$order_where[] = "(oi.shipping_status = '" . SS_SHIPPED . "' OR oi.shipping_status = '" . SS_RECEIVED . "')";
		
		$fields = "COUNT(*) AS order_count, SUM(oi.goods_amount + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee - oi.discount) AS order_amount";
		
		$where = array();
		if ($_SESSION['ru_id'] > 0) {
			/*入驻商*/
			$where['ru_id'] = $_SESSION['ru_id'];
			$where[] = 'oii.order_id is null';
		} else {
			$result = ecjia_app::validate_application('seller');
			if (!is_ecjia_error($result)) {
				/*自营*/
				$where['oi.main_order_id'] = 0;
			}
		}
		if ($_SESSION['ru_id'] > 0) {
			$order_count = $db_orderinfo_view->field('oi.order_id')->where(array_merge(array('oi.add_time' => array('gt' => $today_time)), $where))->group('oi.order_id')->select();
			
			$order_data_today['order_count'] = count($order_count);
			$order_amount_result = $db_orderinfo_view->field('(oi.goods_amount + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee - oi.discount) AS order_amount')->where(array_merge($order_amount_where, array('oi.add_time' => array('gt' => $today_time)), $where))->group('og.order_id')->select();
			$order_amount = 0;
			
			if (!empty($order_amount_result)) {
				foreach ($order_amount_result as $k => $v) {
					$order_amount += $v['order_amount'];
				}
			}

			$order_data_today['order_amount'] = $order_amount;
			
			$yersterday_order_count = $db_orderinfo_view->field('oi.order_id')->where(array_merge(array('oi.add_time' => array('lt' => $today_time, 'gt' => $yesterday_time)), $where))->group('oi.order_id')->select();
			$order_data_yesterday['order_count'] = count($yersterday_order_count);
			$yersterday_order_amount_result = $db_orderinfo_view->field('(oi.goods_amount + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee - oi.discount) AS order_amount')->where(array_merge($order_amount_where, array('oi.add_time' => array('lt' => $today_time, 'gt' => $yesterday_time)), $where))->group('og.order_id')->select();
			
			$yersterday_order_amount = 0;
				
			if (!empty($yersterday_order_amount_result)) {
				foreach ($yersterday_order_amount_result as $k => $v) {
					$yersterday_order_amount += $v['order_amount'];
				}
			}
			
			$order_data_yesterday['order_amount'] = $yersterday_order_amount;
// 			$order_data_yesterday = $db_orderinfo_view->field($fields)->where(array_merge($order_where, array('oi.add_time' => array('lt' => $today_time, 'gt' => $yesterday_time)), $where))->find();
		} else {
			$order_count = $db_orderinfo_view->join(null)->field('COUNT(oi.order_id) AS order_count')->where(array_merge(array('oi.add_time' => array('gt' => $today_time)), $where))->find();
			
			$order_data_today['order_count'] = $order_count['order_count'];
			$order_amount = $db_orderinfo_view->join(null)->field('SUM(oi.goods_amount + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee - oi.discount) AS order_amount')->where(array_merge($order_amount_where, array('oi.add_time' => array('gt' => $today_time)), $where))->find();
			$order_data_today['order_amount'] = $order_amount['order_amount'];
			
			$yersterday_order_count = $db_orderinfo_view->join(null)->field('COUNT(oi.order_id) AS order_count')->where(array_merge(array('oi.add_time' => array('lt' => $today_time, 'gt' => $yesterday_time)), $where))->find();
			
			$order_data_yesterday['order_count'] = $yersterday_order_count['order_count'];
			$yersterday_order_amount = $db_orderinfo_view->join(null)->field('SUM(oi.goods_amount + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee - oi.discount) AS order_amount')->where(array_merge($order_amount_where, array('oi.add_time' => array('lt' => $today_time, 'gt' => $yesterday_time)), $where))->find();
			$order_data_yesterday['order_amount'] = $yersterday_order_amount['order_amount'];
				
// 			$order_data_yesterday['order_count'] = $db_orderinfo_view->join(null)->field('COUNT(oi.order_id) AS order_count')->where(array_merge(array('oi.add_time' => array('lt' => $today_time, 'gt' => $yesterday_time)), $where))->find();
// 			$order_data_yesterday['order_amount'] = $db_orderinfo_view->join(null)->field('SUM(oi.goods_amount + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee - oi.discount) AS order_amount')->where(array_merge($order_amount_where, array('oi.add_time' => array('lt' => $today_time, 'gt' => $yesterday_time)), $where))->get_field('order_amount');
				
// 			$order_data_today = $db_orderinfo_view->join(null)->field($fields)->where(array_merge($order_where, array('oi.add_time' => array('gt' => $today_time)), $where))->find();
// 			$order_data_yesterday = $db_orderinfo_view->join(null)->field($fields)->where(array_merge($order_where, array('oi.add_time' => array('lt' => $today_time, 'gt' => $yesterday_time)), $where))->find();
		}
		
		$order_query = RC_Loader::load_app_class('order_query', 'orders');
		
		$unpaid_where = $order_query->order_await_pay('oi.');
		$await_ship_where = $order_query->order_await_ship('oi.');
		if ($_SESSION['ru_id'] > 0) {
			$await_ship_orders_result = $db_orderinfo_view->field('oi.order_id')->where(array_merge($await_ship_where, $where))->group('oi.order_id')->select('oi.order_id');;
			$unpaid_orders_result = $db_orderinfo_view->field('oi.order_id')->where(array_merge($unpaid_where, $where))->group('oi.order_id')->select('oi.order_id');
			$await_ship_orders = count($await_ship_orders_result);
			$unpaid_orders = count($unpaid_orders_result);
		} else {
			$await_ship_orders = $db_orderinfo_view->join(null)->where(array_merge($await_ship_where, $where))->count('oi.order_id');;
			$unpaid_orders = $db_orderinfo_view->join(null)->where(array_merge($unpaid_where, $where))->count('oi.order_id');
		}
		
		$time = RC_Time::local_date('Y-m-d', RC_Time::gmtime());
		$stats_result = $stats_db->field('FROM_UNIXTIME(access_time, "%Y-%m-%m") as time')->group('ip_address')->having("time = $time")->select();
		$nexttime = RC_Time::local_date('Y-m-d', RC_Time::gmtime()+24*60*60);
		$next_stats_result = $stats_db->field('FROM_UNIXTIME(access_time, "%Y-%m-%m") as time')->group('ip_address')->having("time = $nexttime")->select();
		$total_visitors = round(count($stats_result)*1.2);
		$next_total_visitors = round(count($next_stats_result)*1.2);
		$data['order_stats'] =  array(
				array(
					'key'	=> 'today_orders_proceeds',
					'label'	=> __('今日收益'),
					'value'	=> price_format($order_data_today['order_amount'], false),
				),
				array(
					'key'	=> 'today_orders',
					'label'	=> __('今日订单'),
					'value'	=> intval($order_data_today['order_count']),
				),
// 				array(
// 						'key'	=> 'unpaid_orders',
// 						'label'	=> __('待付款订单'),
// 						'value'	=> intval($unpaid_orders),
// 				),
				array(
					'key'	=> 'today_total_visitors',
					'label' => __('今日访客'),
					'value' => $total_visitors,
				),
				array(
						'key'	=> 'yesterday_orders_proceeds',
						'label'	=> __('昨日收益'),
						'value'	=> price_format($order_data_yesterday['order_amount'], false),
				),
				array(
						'key'	=> 'yesterday_orders',
						'label'	=> __('昨日订单'),
						'value'	=> intval($order_data_yesterday['order_count']),
				),
				array(
						'key'	=> 'yesterday_total_visitors',
						'label' => __('昨日访客'),
						'value' => $next_total_visitors,
				),
// 				array(
// 						'key'	=> 'await_ship_orders',
// 						'label'	=> __('待发货订单'),
// 						'value'	=> intval($await_ship_orders),
// 				),
		);

		
		return $data;
	}
	
	
}


// end