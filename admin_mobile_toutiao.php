<?php
/**
 * 头条
 */
defined('IN_ECJIA') or exit('No permission resources.');
class admin_mobile_toutiao extends ecjia_admin {
	private $db_mobile_toutiao;
	public function __construct() {
		parent::__construct();
		/*加载所需数据模型*/
		$this->db_mobile_toutiao = RC_Loader::load_app_model('mobile_toutiao_model', 'mobile');
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		/* 加载所有全局 js/css */
        RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
        RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
        RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
        RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
        
        RC_Script::enqueue_script('product_news', RC_App::apps_url('statics/js/mobile_toutiao.js', __FILE__));
        RC_Script::localize_script('product_news', 'js_lang', RC_Lang::get('mobile::mobile.js_lang'));
        
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_headline'), RC_Uri::url('mobile/admin_mobile_toutiao/init')));
	}

	/**
	 * 列表页
	 */
	public function init() {
		$this->admin_priv('mobile_toutiao_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_headline')));
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.mobile_headline_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.add_headline'), 'href' => RC_Uri::url('mobile/admin_mobile_toutiao/add')));
		$this->assign('search_action', RC_Uri::url('mobile/admin_mobile_toutiao/init'));
		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_toutiao/batch'));
		
		$lists = $this->get_list();
		$this->assign('lists', $lists);
		
		$this->display('toutiao_list.dwt');
	}
	
	/**
	 * 添加页
	 */
	public function add() {
		$this->admin_priv('mobile_toutiao_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.add_headline')));
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.add_headline'));
		$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.mobile_headline_list'), 'href' => RC_Uri::url('mobile/admin_mobile_toutiao/init')));
		
 		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_toutiao/insert'));
		$this->display('toutiao_edit.dwt');
	}

	/**
	 * 处理添加
	 */
	public function insert() {
		$this->admin_priv('mobile_toutiao_manage');
		
		if (empty($_POST['title'])) {
			$this->showmessage(RC_Lang::get('mobile::mobile.headline_title_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (!empty($_FILES['image']['name'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/toutiao', 'auto_sub_dirs' => false));
			$info = $upload->upload($_FILES['image']);
			if (!empty($info)) {
				$src = $upload->get_position($info);
			} else {
				$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$this->showmessage(RC_Lang::get('mobile::mobile.upload_headline_img'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (strstr($_POST['content_url'], "http://") || strstr($_POST['content_url'], "https://") || strstr($_POST['content_url'], "ecjiaopen://")) {
			$url = $_POST['content_url'];
		} else {
			$url = "http://".$_POST['content_url'];
		}
		
		$data = array(
			'title'  		=> $_POST['title'],
			'tag'			=> $_POST['tag'],
			'description'  	=> $_POST['description'],
			'content_url'  	=> $url,
			'image'			=> $src,
			'sort_order'	=> isset($_POST['sort_order']) ? intval($_POST['sort_order']) : 100, 
			'status'		=> isset($_POST['status']) ?  1 : 0,
			'create_time' 	=> RC_Time::gmtime()
		);
		$id = $this->db_mobile_toutiao->insert($data);
		
		ecjia_admin::admin_log($_POST['title'], 'add', 'mobile_toutiao');
		
		$links[] = array('text' => RC_Lang::get('mobile::mobile.return_headline_list'), 'href' => RC_Uri::url('mobile/admin_mobile_toutiao/init'));
		$links[] = array('text' => RC_Lang::get('mobile::mobile.continue_add_headline'), 'href' => RC_Uri::url('mobile/admin_mobile_toutiao/add'));
		if ($id) {
			$this->showmessage(RC_Lang::get('mobile::mobile.add_headline_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('mobile/admin_mobile_toutiao/edit', array('id' => $id))));
		} else {
			$this->showmessage(RC_Lang::get('mobile::mobile.add_headline_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 编辑页
	 */
	public function edit() {
		$this->admin_priv('mobile_toutiao_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.edit_headline')));
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.edit_headline'));
		$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.mobile_headline_list'), 'href' => RC_Uri::url('mobile/admin_mobile_toutiao/init')));
		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_toutiao/update'));
		
		$data = $this->db_mobile_toutiao->where(array('id' => $_GET['id']))->find();
		$data['image'] = !empty($data['image']) ? RC_Upload::upload_url($data['image']) : '';
		if ($data['create_time']) {
			$data['create_time'] = RC_Time::local_date(ecjia::config('time_format') , $data['create_time']);
		}
		$this->assign('data', $data);
		$this->display('toutiao_edit.dwt');
	}

	/**
	 * 处理编辑
	 */
	public function update() {
		$this->admin_priv('mobile_toutiao_manage');

		if (empty($_POST['title'])) {
			$this->showmessage(RC_Lang::get('mobile::mobile.headline_title_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (strstr($_POST['content_url'], "http://") || strstr($_POST['content_url'], "https://")  || strstr($_POST['content_url'], "ecjiaopen://")) {
			$url = $_POST['content_url'];
		} else {
			$url = "http://".$_POST['content_url'];
		}
		
		$data = array(
			'title'  		=> $_POST['title'],
			'tag'			=> $_POST['tag'],
			'description'  	=> $_POST['description'],
			'sort_order'	=> isset($_POST['sort_order']) ? intval($_POST['sort_order']) : 100,
			'status'		=> isset($_POST['status']) ?  1 : 0,
			'content_url'  	=> $url,
			'update_time' 	=> RC_Time::gmtime()
		);
		
		if (!empty($_FILES['image']['name'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/toutiao', 'auto_sub_dirs' => false));
			$info = $upload->upload($_FILES['image']);
			if (!empty($info)) {
				$src = $upload->get_position($info);
				$data['image'] = $src;
				/* 获取旧的图片地址,并删除 */
				$old_pic = $this->db_mobile_toutiao->where(array('id' => $_POST['id']))->get_field('image');
				$upload->remove($old_pic);
			} else {
				$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		$update = $this->db_mobile_toutiao->where(array('id' => $_POST['id']))->update($data);
		ecjia_admin::admin_log($_POST['title'], 'edit', 'mobile_toutiao');
		if ($update) {
			$this->showmessage(RC_Lang::get('mobile::mobile.edit_headline_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_toutiao/edit', array('id' => $_POST['id']))));
		} else {
			$this->showmessage(RC_Lang::get('mobile::mobile.edit_headline_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 删除
	 */
	public function remove() {
		$this->admin_priv('mobile_toutiao_delete');
		
		$info = $this->db_mobile_toutiao->where(array('id' => $_GET['id']))->find();
		$delete = $this->db_mobile_toutiao->where(array('id' => $_GET['id'] ))->delete();
 		
		$disk = RC_Filesystem::disk();
		$disk->delete(RC_Upload::upload_path($info['image']));
 		ecjia_admin::admin_log($info['title'], 'remove', 'mobile_toutiao');
 		if ($delete) {
 			$this->showmessage(RC_Lang::get('mobile::mobile.drop_headline_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
 		} else {
 			$this->showmessage(RC_Lang::get('mobile::mobile.drop_headline_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
 		}
	}
	
	/**
	 * 删除图片
	 */
	public function remove_image() {
		$this->admin_priv('mobile_toutiao_delete');
	
		$info = $this->db_mobile_toutiao->where(array('id' => $_GET['id']))->find();
		$this->db_mobile_toutiao->where(array('id' => $_GET['id'] ))->update(array('image'=>''));
			
		$disk = RC_Filesystem::disk();
		$disk->delete(RC_Upload::upload_path($info['image']));
		
		$this->showmessage(RC_Lang::get('mobile::mobile.drop_image_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 批量操作
	 */
	public function batch() {
		$this->admin_priv('mobile_toutiao_delete');
		
		if (isset($_POST['checkboxes'])) {
			$idArr = explode(',' , $_POST['checkboxes']);
			
			$title_list = $this->db_mobile_toutiao->in(array('id' => $idArr))->select();
			$disk = RC_Filesystem::disk();
			foreach ($title_list as $v) {
				$disk->delete(RC_Upload::upload_path($v['image']));
				ecjia_admin::admin_log($v['title'], 'batch_remove', 'mobile_toutiao');
			}
			$this->db_mobile_toutiao->in(array('id' => $idArr))->delete();
			
			$this->showmessage(RC_Lang::get('mobile::mobile.drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_toutiao/init')));
		} else {
			$this->showmessage(RC_Lang::get('mobile::mobile.pls_selece_option'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 获取列表
	 * @return array
	 */
	private function get_list() {
		$keywords = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		$where = '';
		if ($keywords) {
			$where['title'] = array('like' => '%'.$keywords.'%');
		}
		
		$count = $this->db_mobile_toutiao->where($where)->count();
		$page = new ecjia_page($count, 10, 5);
		
		$rows = $this->db_mobile_toutiao->where($where)->order(array('create_time' => 'desc'))->limit($page->limit())->select();
		if (!empty($rows)) {
			foreach ($rows as $key => $val) {
				$rows[$key]['create_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['create_time']);
				$rows[$key]['image'] = empty($val['image']) ? '' : RC_Upload::upload_url($val['image']);
			}	
		}
		
		$arr = array('item' => $rows, 'page' => $page->show(5), 'desc' => $page->page_desc());
		return $arr;
	}
}
// end
