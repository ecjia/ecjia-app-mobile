<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 今日头条
 * @author will.chen
 *
 */
class toutiao_module implements ecjia_interface {

	public function run(ecjia_api & $api) {
		
		$db_mobile_toutiao = RC_Loader::load_app_model('mobile_toutiao_model', 'mobile');
		/* 查询今日热点总数*/
		$count = $db_mobile_toutiao->where(array('status' => 1))->count();
		
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
		
		//实例化分页
		$page_row = new ecjia_page($count, $size, 6, '', $page);
		
		$result = $db_mobile_toutiao->where(array('status' => 1))->limit($page_row->limit())->order(array('sort_order' => 'asc', 'id' => 'desc'))->select();
		
		$list = array();
		if ( !empty ($result)) {
			foreach ($result as $val) {
				$list[] = array(
						'image' => RC_Upload::upload_url(). '/' .$val['image'],
						'tag'	=> $val['tag'],
						'title'	=> $val['title'],
						'url'	=> $val['content_url'],
						'time'  => RC_Time::local_date(ecjia::config('time_format'), $val['create_time']),
				);
			}
		}
		
		
		$pager = array(
				"total" => $page_row->total_records,
				"count" => $page_row->total_records,
				"more"	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		EM_Api::outPut($list, $pager);
		
	}
}



// end