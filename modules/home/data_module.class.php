<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 首页轮播图及推荐数据
 * @author royalwang
 *
 */
class data_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authSession();	
    	
		$device = $this->requestdata('device', array());
		$location = $this->requestdata('location',array()); 
// 		$location = array(
// 				'latitude'	=> '31.235450744628906',
// 				'longitude' => '121.41641998291016',
// 		);

		$request = null;
		if (is_array($location) && isset($location['latitude']) && isset($location['longitude'])) {
			$request = array('location' => $location);
			$geohash = RC_Loader::load_app_class('geohash', 'shipping');
			$geohash_code = $geohash->encode($location['latitude'] , $location['longitude']);
			$geohash_code = substr($geohash_code, 0, 5);
			$request['geohash_code'] = $geohash_code;
		}
		
		$device['code'] = isset($device['code']) ? $device['code'] : '';
		$cache_key = 'api_home_data_'.$_SESSION['user_rank'].'_'.ecjia::config('lang').'_'.$device['code'].'_'.$geohash_code;

		$response = RC_Cache::app_cache_get($cache_key, 'mobile');
		if (empty($response)) {
			$db = RC_Loader::load_app_model('goods_model', 'goods');
			RC_Loader::load_app_func('global', 'api');
			
			//流程逻辑开始
			// runloop 流
			$response = array();

			$response = RC_Hook::apply_filters('api_home_data_runloop', $response, $request);//mobile_home_adsense1
			RC_Cache::app_cache_set($cache_key, $response, 'mobile', 60);
		}
		return $response;
			
	}
}

function cycleimage_data($response, $request) {
	$mobile_cycleimage = RC_Loader::load_app_class('mobile_method', 'mobile');
	$device = $this->requestdata('device', array());
	
	if (isset($device['client']) && $device['client'] == 'ipad') {
		$cycleimageDatas = $mobile_cycleimage->cycleimage_data(true);
	} else {
		$cycleimageDatas = $mobile_cycleimage->cycleimage_phone_data(true);
	}
	
	$player_data = array();
	foreach ($cycleimageDatas as $val) {
		$player_data[] = array(
				'photo'      => array(
						'small'      => $val['src'],
						'thumb'      => $val['src'],
						'url'        => $val['src'],
				),
				'url'        => $val['url'],
				'description'=> $val['text'],
		);
	}
	
	/* 限制轮播图片显示最多5张 */
	if (count($player_data) > 5) {
		$player_data = array_slice($player_data, 0, 5);
	}
	
	/* url解析判断规律   适用于2.8以及以前，之后是否废弃需确认*/
// 	foreach ($player_data as $key => $val) {
// 		$action_info = api_get_url($val['url']);
// 		$player_data[$key]['action'] = $action_info['action'];
// 		$player_data[$key]['action_id'] = $action_info['action_id'];
// 	}
	
	$response['player'] = $player_data;
	
	return $response;
}

function mobile_menu_data($response, $request) {
	$mobile = RC_Loader::load_app_class('mobile_method','mobile');
	$mobile_menu = array_merge($mobile->shortcut_data(true));
	$mobile_menu_data = array();
	if (!empty($mobile_menu)) {
		foreach ($mobile_menu as $key => $val) {
			if ($val['display'] == '1') {
				$mobile_menu_data[] = array(
						'image'	=> $val['src'],
						'text'	=> $val['text'],
						'url'	=> $val['url']
				);
			}
		}
	}

	$response['mobile_menu'] = $mobile_menu_data;
	return $response;
}

function promote_goods_data($response, $request) {
	$promote_goods_data = array();
	$order_sort = array('sort_order' => 'ASC', 'goods_id' => 'DESC');
	$filter = array(
			'intro'	=> 'promotion', 
			'sort'	=> $order_sort,
			'page'	=> 1,
			'size'	=> 6,
			'location' => $request['location']
	);
	$result = RC_Api::api('goods', 'goods_list', $filter);
	
	if ( !empty($result['list']) ) {
		foreach ( $result['list'] as $key => $val ) {
			$promote_goods_data[] = array(
					'id'		=> intval($val['goods_id']),
					'goods_id'	=> intval($val['goods_id']),           //多商铺中不用，后期删除
					'name'		=> $val['goods_name'],
					'market_price'	=> $val['market_price'],
					'shop_price'	=> $val['shop_price'],
					'promote_price'	=> $val['promote_price'],
					'img' => array(
							'small' => $val['goods_thumb'],
							'thumb' => $val['goods_img'],
							'url'	=> $val['original_img'],
					)
			);
		}
	}

	$response['promote_goods'] = $promote_goods_data;
	return $response;
}

function new_goods_data($response, $request) {
	$new_goods_data = array();
	
	$order_sort = array('sort_order' => 'ASC', 'goods_id' => 'DESC');
	$filter = array(
			'intro'	=> 'new',
			'sort'	=> $order_sort,
			'page'	=> 1,
			'size'	=> 6,
			'location' => $request['location']
	);
	$result = RC_Api::api('goods', 'goods_list', $filter);
	
	if ( !empty($result['list']) ) {
		foreach ( $result['list'] as $key => $val ) {
			$new_goods_data[] = array(
					'id'		=> intval($val['goods_id']),
					'goods_id'	=> intval($val['goods_id']),           //多商铺中不用，后期删除
					'name'		=> $val['goods_name'],
					'market_price'	=> $val['market_price'],
					'shop_price'	=> $val['shop_price'],
					'promote_price'	=> $val['promote_price'],
					'img' => array(
							'small' => $val['goods_thumb'],
							'thumb' => $val['goods_img'],
							'url'	=> $val['original_img'],
					)
			);
		}
	}

	$response['new_goods'] = $new_goods_data;
	return $response;
}

// function mobile_tv_adsense_data($response, $request) {
// 	$device = $this->requestdata('device', array());
// 	if (isset($device['code']) && $device['code'] == '1006') {
// 		$mobile_tv_adsense_group = unserialize(ecjia::config('mobile_tv_adsense_group'));
// 		if ($mobile_tv_adsense_group['big_group'] == '' || $mobile_tv_adsense_group['big_group'] == 0) {
// 			$response['mobile_tv_big_adsense'] = array();
// 		} else {
// 			$ad_view = RC_Loader::load_app_model('ad_model', 'adsense');
// 			$adsense = array(
// 					'position_id'	=> $mobile_tv_adsense_group['big_group'],
// 					'start_time'	=> array('elt' => RC_Time::gmtime()),
// 					'end_time'		=> array('egt' => RC_Time::gmtime()),
// 					'enabled'		=> 1,
// 			);
// 			$adsense_result = $ad_view->where($adsense)->order('ad_id')->select();
			
// 			$mobile_tv_big_adsense = array();
// 			if (!empty($adsense_result)) {
// 				foreach ($adsense_result as $val) {
// 					if (substr($val['ad_code'], 0, 4) != 'http') {
// 						$val['ad_code'] = RC_Upload::upload_url().'/'.$val['ad_code'];
// 					}
// 					$mobile_tv_big_adsense[] = array(
// 							'image'	=> $val['ad_code'],
// 							'text'	=> $val['ad_name'],
// 							'url'	=> $val['ad_link'],
// 					);
// 				}
// 			}
			
// 			$response['mobile_tv_big_adsense'] = $mobile_tv_big_adsense;
// 		}
// 		if ($mobile_tv_adsense_group['small_group'] == '' || $mobile_tv_adsense_group['small_group'] == 0) {
// 			$response['mobile_tv_small_adsense'] = array();
// 		} else {
// 			$ad_view = RC_Loader::load_app_model('ad_model', 'adsense');
// 			$adsense = array(
// 					'position_id'	=> $mobile_tv_adsense_group['small_group'],
// 					'start_time'	=> array('elt' => RC_Time::gmtime()),
// 					'end_time'		=> array('egt' => RC_Time::gmtime()),
// 					'enabled'		=> 1,
// 			);
// 			$adsense_result = $ad_view->where($adsense)->order('ad_id')->select();
			
// 			$mobile_tv_small_adsense = array();
// 			if (!empty($adsense_result)) {
// 				foreach ($adsense_result as $val) {
// 					if (substr($val['ad_code'], 0, 4) != 'http') {
// 						$val['ad_code'] = RC_Upload::upload_url().'/'.$val['ad_code'];
// 					}
// 					$mobile_tv_small_adsense[] = array(
// 							'image'	=> $val['ad_code'],
// 							'text'	=> $val['ad_name'],
// 							'url'	=> $val['ad_link'],
// 					);
// 				}
// 			}
			
// 			$response['mobile_tv_small_adsense'] = $mobile_tv_small_adsense;
// 		}
// 	}
	
// 	return $response;
// }


function mobile_home_adsense_group($response, $request) {
	if (ecjia::config('mobile_home_adsense_group') == '' || ecjia::config('mobile_home_adsense_group') == 0) {
		$response['adsense_group'] = array();
	} else {
		$ad_view = RC_Loader::load_app_model('ad_model', 'adsense');
		$adsense_group = explode(',', ecjia::config('mobile_home_adsense_group'));
		$mobile_home_adsense_group = array();
		if (!empty($adsense_group)) {
			$i = 0;
			foreach ($adsense_group as $val) {
				$adsense = RC_Api::api('adsense', 'adsense_position_list', array('position_id' => $val));
				if (!empty($adsense['arr'])) {
					$adsense_info = $adsense['arr'][0];
				} else {
					continue;
				}
				$mobile_home_adsense_group[$i]['title'] = $adsense_info['position_name'];
				$adsense = array(
						'position_id'	=> $val,
						'start_time'	=> array('elt' => RC_Time::gmtime()),
						'end_time'		=> array('egt' => RC_Time::gmtime()),
						'enabled'		=> 1,
				);
					
				$adsense_result = $ad_view->where($adsense)->order('ad_id')->limit(4)->select();
				if (!empty($adsense_result)) {
					foreach ($adsense_result as $v) {
						if (substr($v['ad_code'], 0, 4) != 'http') {
							$v['ad_code'] = RC_Upload::upload_url().'/'.$v['ad_code'];
						}
						$mobile_home_adsense_group[$i]['adsense'][] = array(
								'image'	=> $v['ad_code'],
								'text'	=> $v['ad_name'],
								'url'	=> $v['ad_link'],
						);
					}
					$i++;
				}
			}
		}
		
		$response['adsense_group'] = $mobile_home_adsense_group;
	}
	
	return $response;
}

function group_goods_data($response, $request) {
	$result = ecjia_app::validate_application('groupbuy');
	if (!is_ecjia_error($result)) {
		//团购列表
		$groupwhere['act_type']		= GAT_GROUP_BUY;
		$groupwhere['start_time']	= array('elt' => RC_Time::gmtime());
		$groupwhere['end_time']		= array('egt' => RC_Time::gmtime());
		$groupwhere['is_finished'] 	= 0;
		$groupwhere[] = 'g.goods_id is not null';
		$groupwhere['g.is_delete'] = '0';
		$groupwhere['g.is_on_sale'] = 1;
    	$groupwhere['g.is_alone_sale'] = 1;
		/* 判断是否是多商户*/
		$is_seller = ecjia_app::validate_application('seller');
		if (!is_ecjia_error($is_seller)) {
			if (ecjia::config('review_goods')) {
				$groupwhere['g.review_status'] = array('gt' => 2);
			}
		}
		
// 		if (isset($request['o2o_seller'])) {
// 			$groupwhere['g.user_id'] = $request['o2o_seller'];
// 		}

		/* 根据经纬度查询附近店铺*/
		if (isset($request['geohash_code']) && !empty($request['geohash_code'])) {
			$groupwhere['geohash'] = array('like' => "%".$request['geohash_code']."%");
		}
		
		$db_goods_activity = RC_Loader::load_app_model('goods_activity_viewmodel', 'goods');
		
		$res = $db_goods_activity->field('ga.act_id, ga.goods_id, ga.goods_name, ga.start_time, ga.end_time, ext_info, shop_price, market_price, goods_brief, goods_thumb, goods_img, original_img')
								 ->join(array('goods', 'seller_shopinfo'))
								 ->where($groupwhere)
								 ->limit(4)
								 ->order(array('ga.act_id' => 'desc'))
								 ->select();

		$group_goods_data = array();
		if (!empty($res)) {
			foreach ($res as $val) {
				$ext_info = unserialize($val['ext_info']);
				$price_ladder = $ext_info['price_ladder'];
				if (!is_array($price_ladder) || empty($price_ladder)) {
					$price_ladder = array(array('amount' => 0, 'price' => 0));
				} else {
					foreach ($price_ladder AS $key => $amount_price) {
						$price_ladder[$key]['formated_price'] = price_format($amount_price['price']);
					}
				}

				$cur_price  = $price_ladder[0]['price'];    // 初始化
				$group_goods_data[] = array(
						'id'	=> $val['goods_id'],
						'name'	=> $val['goods_name'],
						'market_price'	=> price_format($val['market_price'], false),
						'shop_price'	=> price_format($val['market_price'], false),
						'promote_price'	=> price_format($cur_price, false),
						'promote_start_date'	=> RC_Time::local_date('Y/m/d H:i:s', $val['start_time']),
						'promote_end_date'		=> RC_Time::local_date('Y/m/d H:i:s', $val['end_time']),
						'brief' => $val['goods_brief'],
						'img'	=> array(
								'small'	=> RC_Upload::upload_url(). '/' .$val['goods_thumb'],
								'thumb'	=> RC_Upload::upload_url(). '/' .$val['goods_img'],
								'url'	=> RC_Upload::upload_url(). '/' .$val['original_img']
						),
						'object_id'	=> $val['act_id'],
						'rec_type'	=> 'GROUPBUY_GOODS'
				);
			}
		}

		$response['group_goods'] = $group_goods_data;
		return $response;
	} else {
		return $response;
	}
}

function mobilebuy_goods_data($response, $request) {
	$result = ecjia_app::validate_application('mobilebuy');
	if (!is_ecjia_error($result)) {
		$mobilebuywhere['act_type']		= GAT_MOBILE_BUY;
		$mobilebuywhere['start_time']	= array('elt' => RC_Time::gmtime());
		$mobilebuywhere['end_time']		= array('egt' => RC_Time::gmtime());
		$mobilebuywhere[] = 'g.goods_id is not null';
		$mobilebuywhere['g.is_delete'] = '0';
		$mobilebuywhere['g.is_on_sale'] = 1;
		$mobilebuywhere['g.is_alone_sale'] = 1;
		if (ecjia::config('review_goods')) {
			$mobilebuywhere['g.review_status'] = array('gt' => 2);
		}
		
// 		if (isset($request['o2o_seller'])) {
// 			$mobilebuywhere['g.user_id'] = $request['o2o_seller'];
// 		}
		
		/* 根据经纬度查询附近店铺*/
		if (isset($request['geohash_code']) && !empty($request['geohash_code'])) {
			$mobilebuywhere['geohash'] = array('like' => "%".$request['geohash_code']."%");
		}
		
		$db_goods_activity = RC_Loader::load_app_model('goods_activity_viewmodel', 'goods');
		$res = $db_goods_activity->field('ga.act_id, ga.goods_id, ga.goods_name, ga.start_time, ga.end_time, ext_info, shop_price, market_price, goods_brief, goods_thumb, goods_img, original_img')
								 ->join(array('goods', 'seller_shopinfo'))
								 ->where($mobilebuywhere)
								 ->order(array('act_id' => 'DESC'))
								 ->limit(4)->select();
		 
		$mobilebuy_goods = array();
		if (!empty($res)) {
			foreach ($res as $val) {
				$ext_info = unserialize($val['ext_info']);
				$price  = $ext_info['price'];;    		// 初始化
				/* 计算节约价格*/
				$saving_price = ($val['shop_price'] - $price) > 0 ? $val['shop_price'] - $price : 0;
				$mobilebuy_goods[] = array(
						'id'	=> $val['goods_id'],
						'name'	=> $val['goods_name'],
						'market_price'	=> price_format($val['market_price'], false),
						'shop_price'	=> price_format($val['shop_price'], false),
						'promote_price'	=> price_format($price, false),
						'promote_start_date'	=> RC_Time::local_date('Y/m/d H:i:s', $val['start_time']),
						'promote_end_date'		=> RC_Time::local_date('Y/m/d H:i:s', $val['end_time']),
						'brief' => $val['goods_brief'],
						'img'	=> array(
								'small'	=> RC_Upload::upload_url(). '/' .$val['goods_thumb'],
								'thumb'	=> RC_Upload::upload_url(). '/' .$val['goods_img'],
								'url'	=> RC_Upload::upload_url(). '/' .$val['original_img']
						),
						'activity_type' => 'MOBILEBUY_GOODS',
						'saving_price'	=> $saving_price,
						'formatted_saving_price' => '已省'.$saving_price.'元',
						'object_id'	=> $val['act_id'],
						'rec_type'	=> 'MOBILEBUY_GOODS'
				);
			}
		}
		$response['mobile_buy_goods'] = $mobilebuy_goods;
		return $response;
	} else {
		return $response;
	}
}

function seller_recommend_data($response, $request) {
	$result = ecjia_app::validate_application('seller');
	$is_active = ecjia_app::is_active('ecjia.seller');
	
	if (!is_ecjia_error($result) && $is_active) {
// 		$msi_dbview = RC_Loader::load_app_model('merchants_shop_information_viewmodel', 'seller');
		$ssi_dbview = RC_Loader::load_app_model('seller_shopinfo_viewmodel', 'seller');
		
// 		$where['ssi.status'] = 1;
// 		$where['msi.merchants_audit'] = 1;
		$order_by = array('follower' => 'DESC', 'ssi.id' => 'DESC');
		
		$user_id = $_SESSION['user_id'];
		$user_id = empty($user_id) ? 0 : $user_id;
		
// 		if (isset($request['o2o_seller'])) {
// 			$where['msi.user_id'] = $request['o2o_seller'];
// 		}
		
		/* 根据经纬度查询附近店铺*/
		if (isset($request['geohash_code']) && !empty($request['geohash_code'])) {
			$where['geohash'] = array('like' => "%".$request['geohash_code']."%");
		}
		
		$field ='ssi.id as seller_id, ssi.shop_name as seller_name, ssi.*, sc.cat_name, count(cs.seller_id) as follower, SUM(IF(cs.user_id = '.$user_id.',1,0)) as is_follower';
// 		$result = $msi_dbview->join(array('category', 'seller_shopinfo', 'collect_store'))
		$result = $ssi_dbview->join(array('seller_category', 'collect_store'))
								->field($field)
								->where($where)
								->limit(6)
								->group('ssi.id')
								->order($order_by)
								->select();
		$list = array();
		
		if (!empty ($result)) {
			$goods_db = RC_Loader::load_app_model('goods_model', 'goods');
			$warehouse_goodsdb = RC_Loader::load_app_model('warehouse_goods_model', 'seller');
			$warehouse_areagoodsdb = RC_Loader::load_app_model('warehouse_area_goods_model', 'seller');
			RC_Loader::load_app_func('common', 'goods');
			RC_Loader::load_app_func('goods', 'goods');
			$mobilebuy_db = RC_Loader::load_app_model('goods_activity_model', 'goods');
			$v_where = array('is_on_sale' => 1, 'is_alone_sale' => 1, 'is_delete' => 0);
			
			foreach ($result as $key => $val) {
// 				$v_where['user_id'] = $val['user_id'];
				$v_where['seller_id'] = $val['seller_id'];
				if(ecjia::config('review_goods') == 1){
					$v_where['review_status'] = array('gt' => 2);
				}
				$goods_result = $goods_db->where($v_where)->limit(3)->order(array('sort_order' => 'asc', 'goods_id' => 'desc'))->select();
				$goods_count = $goods_db->where($v_where)->count();
				$goods_list = array();
				if (!empty ($goods_result)) {
					foreach ($goods_result as $v) {
						//仓库价格
						if ($v['model_price'] == 1) {
							$price = $warehouse_goodsdb->where(array('goods_id' => $v['goods_id']))->get_field('warehouse_price');
							$v['shop_price'] = empty($price) ? $v['shop_price'] : $price;
							$v['promote_price'] = $warehouse_goodsdb->where(array('goods_id' => $v['goods_id']))->get_field('warehouse_promote_price');
						}
						//区域价格
						if ($v['model_price'] == 2) {
							$price = $warehouse_areagoodsdb->where(array('goods_id' => $v['goods_id']))->get_field('region_price');
							$v['shop_price'] = empty($price) ? $v['shop_price'] : $price;
							$v['promote_price'] = $warehouse_areagoodsdb->where(array('goods_id' => $v['goods_id']))->get_field('region_promote_price');
						}
						/* 修正促销价格 */
						if ($v ['promote_price'] > 0) {
							$promote_price = bargain_price($v['promote_price'], $v['promote_start_date'], $v['promote_end_date']);
						} else {
							$promote_price = 0;
						}
		
						$groupbuy = $mobilebuy_db->find(array(
								'goods_id'	 => $v['goods_id'],
								'start_time' => array('elt' => RC_Time::gmtime()),
								'end_time'	 => array('egt' => RC_Time::gmtime()),
								'act_type'	 => GAT_GROUP_BUY,
						));
						$mobilebuy = $mobilebuy_db->find(array(
								'goods_id'	 => $v['goods_id'],
								'start_time' => array('elt' => RC_Time::gmtime()),
								'end_time'	 => array('egt' => RC_Time::gmtime()),
								'act_type'	 => GAT_MOBILE_BUY,
						));
						/* 判断是否有促销价格*/
						$price = ($v['shop_price'] > $promote_price && $promote_price > 0) ? $promote_price : $v['shop_price'];
						$activity_type = ($v['shop_price'] > $promote_price && $promote_price > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
		
						$mobilebuy_price = $groupbuy_price = $object_id = 0;
						if (!empty($mobilebuy)) {
							$ext_info = unserialize($mobilebuy['ext_info']);
							$mobilebuy_price = $ext_info['price'];
							$price = $mobilebuy_price > $price ? $price : $mobilebuy_price;
							$activity_type = $mobilebuy_price > $price ? $activity_type : 'MOBILEBUY_GOODS';
							$object_id = $mobilebuy_price > $price ? $object_id : $mobilebuy['act_id'];
						}
						
						/* 计算节约价格*/
						$saving_price = ($v['shop_price'] - $price) > 0 ? $v['shop_price'] - $price : 0;
		
						$goods_list[] = array(
								'id'			=> $v['goods_id'],
								'name'			=> $v['goods_name'],
								'market_price'	=> price_format($v['market_price']),
								'shop_price'	=> price_format($v['shop_price']),
								'promote_price' => ($price < $v['shop_price'] && $price > 0) ? price_format($price) : '',
								'img' => array(
										'thumb'	=> get_image_path($v['goods_id'], $v['goods_img'], true),
										'url'	=> get_image_path($v['goods_id'], $v['original_img'], true),
										'small'	=> get_image_path($v['goods_id'], $v['goods_thumb'], true),
								),
								'activity_type' => $activity_type,
								'object_id'		=> $object_id,
								'saving_price'	=> $saving_price,
								'formatted_saving_price' => '已省'.$saving_price.'元'
						);
					}
				}
				if(substr($val['shop_logo'], 0, 1) == '.') {
					$val['shop_logo'] = str_replace('../', '/', $val['shop_logo']);
				}
		
		
				$list[] = array(
						'id'				=> $val['seller_id'],
						'seller_name'		=> $val['seller_name'],
						'seller_category'	=> $val['cat_name'],
						'seller_logo'		=> empty($val['shop_logo']) ?  '' : RC_Upload::upload_url().'/'.$val['shop_logo'],
						'seller_goods'		=> $goods_list,
						'follower'			=> $val['follower'],
						'is_follower'		=> $val['is_follower'],
						'goods_count'		=> $goods_count,
				);
		
			}
		}
		
		$response['seller_recommend'] = $list;
		return $response;
	} else {
		return $response;
	}
}

function topic_data($response, $request) {
	if (ecjia::config('mobile_topic_adsense') == '' || ecjia::config('mobile_topic_adsense') == 0) {
		$response['mobile_topic_adsense'] = array();
	} else {
		$ad_view = RC_Loader::load_app_model('ad_model', 'adsense');
		$adsense = array(
				'position_id'	=> ecjia::config('mobile_topic_adsense'),
				'start_time'	=> array('elt' => RC_Time::gmtime()),
				'end_time'		=> array('egt' => RC_Time::gmtime()),
				'enabled'		=> 1,
		);
		$adsense_result = $ad_view->where($adsense)->order('ad_id')->select();
		
		$mobile_topic_adsense_data = array();
		if (!empty($adsense_result)) {
			foreach ($adsense_result as $val) {
				if (substr($val['ad_code'], 0, 4) != 'http') {
					$val['ad_code'] = RC_Upload::upload_url().'/'.$val['ad_code'];
				}
				$mobile_topic_adsense_data[] = array(
						'image'	=> $val['ad_code'],
						'text'	=> $val['ad_name'],
						'url'	=> $val['ad_link'],
				);
			}
		}
		
		$response['mobile_topic_adsense'] = $mobile_topic_adsense_data;
	}
	return $response;
}

function mobile_toutiao_data($response, $request) {
	$db_toutiao = RC_Loader::load_app_model('mobile_toutiao_model', 'mobile');
	$result = $db_toutiao->order(array('sort_order' => 'ASC' , 'id' => 'desc'))->limit(5)->select();
	$mobile_toutiao_data = array();
	if (!empty($result)) {
		foreach ($result as $val) {
			$mobile_toutiao_data[] = array(
					'tag'	=> $val['tag'],
					'title'	=> $val['title'],
					'url'	=> $val['content_url'],
			);
		}
	}
	
	$response['toutiao'] = $mobile_toutiao_data;
	return $response;
}

// // url解析
// function api_get_url($url) {

//     $out = array(
//             'action' => '',
//             'action_id' => 0
//         );
//     //$site_url = dirname($GLOBALS['ecs']->url());
    
// 	$site_url=dirname(SITE_URL);//获取路径  $site_url=dirname(RC_Config::system('CUSTOM_MAIN_SITE_URL'));//获取路径
//     if (strpos($url, $site_url) === false) {
//         return $out;
//     }

//     if (strpos($url, '/goods.php') !== false) {
//         $action = 'goods';
//         $act_arr = explode('/goods.php', $url);
//         if (strpos($act_arr[1], '?id=') !== false) {
//             $action_id = ltrim($act_arr[1], '?id=');
//         }
//     } else if (strpos($url, '/category.php') !== false) {
//         $action = 'category';
//         $act_arr = explode('/category.php', $url);
//         if (strpos($act_arr[1], '?id=') !== false) {
//             $action_id = ltrim($act_arr[1], '?id=');
//         }
//     } else if (strpos($url, '/brand.php') !== false) {
//         $action = 'brand';
//         $act_arr = explode('/brand.php', $url);
//         if (strpos($act_arr[1], '?id=') !== false) {
//             $action_id = ltrim($act_arr[1], '?id=');
//         }
//     } else {
//         return $out;
//     }

//     $out['action'] = $action;
//     $out['action_id'] = (int)$action_id;

//     return $out;
// }


RC_Hook::add_filter('api_home_data_runloop', 'cycleimage_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'mobile_menu_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'promote_goods_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'new_goods_data', 10, 2);
// RC_Hook::add_filter('api_home_data_runloop', 'mobile_tv_adsense_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'mobile_home_adsense_group', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'group_goods_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'mobilebuy_goods_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'seller_recommend_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'topic_data', 10, 2);
// RC_Hook::add_filter('api_home_data_runloop', 'mobile_toutiao_data', 10, 2);

// end