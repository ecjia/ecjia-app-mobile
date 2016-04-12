<?php
/**
 * ECJia今日热点管理控制器
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_mobile_news extends ecjia_admin {

	private $db_mobile_news;

	public function __construct() {
		parent::__construct();

		$this->db_mobile_news = RC_Loader::load_app_model('mobile_news_model');

		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Style::enqueue_style('chosen');

		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');

		RC_Style::enqueue_style('mobile_news', RC_App::apps_url('statics/css/mobile.css' , __FILE__), array(), false, false);
		RC_Script::enqueue_script('mobile_news', RC_App::apps_url('statics/js/mobile_news.js' , __FILE__), array(), false, false);

		RC_Script::enqueue_script('bootstrap-placeholder');

		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('今日热点'), RC_Uri::url('mobile/admin_mobile_news/init')));
	}

	/**
	 * 今日热点页面加载
	 */
	public function init () {
		$this->admin_priv('mobile_news_manage');
		/* 查询今日热点总数*/
		$count = $this->db_mobile_news->where(array('group_id' => 0, 'type' => 'article'))->count();

		$page = new ecjia_page ($count, 10, 5);
		$result = $this->db_mobile_news->where(array('group_id' => 0, 'type' => 'article'))->limit($page->limit())->select();
		$mobile_news = array();
		if ( !empty ($result)) {
			foreach ($result as $key => $val) {
				if (!empty($val['image'])) {
					if (substr($val['image'], 0, 4) != 'http') {
						$val['image'] = RC_Upload::upload_url() . '/' . $val['image'];
					}
				}
				$mobile_news[$key] = array(
						'id'		=> $val['id'],
						'title'		=> $val['title'],
						'description' => $val['description'],
						'image'		  => $val['image'],
						'content_url' => $val['content_url'],
						'create_time' => RC_Time::local_date(ecjia::config('time_format'), $val['create_time']),
				);

				$child_result = $this->db_mobile_news->where(array('group_id' => $val['id'], 'type' => 'article'))->select();
				if ( !empty($child_result)) {
					foreach ($child_result as $v) {
						if (!empty($v['iamge'])) {
							if (substr($v['image'], 0, 4) != 'http') {
								$v['image'] = RC_Upload::upload_url() . '/' . $v['image'];
							}
						}
						$mobile_news[$key]['children'][] = array(
							'id'		=> $v['id'],
							'title'		=> $v['title'],
							'description' => $v['description'],
							'image'		  => $v['image'],
							'content_url' => $v['content_url'],
							'create_time' => RC_Time::local_date(ecjia::config('time_format'), $v['create_time']),
						);
					}
				}
			}
		}

		$this->assign('mobile_news', $mobile_news);
		$this->assign('mobile_news_page', $page->show(5));
		$this->assign('action_link', array('text' => __('添加今日热点'), 'href' => RC_Uri::url('mobile/admin_mobile_news/add')));
		ecjia_screen::$current_screen->remove_last_nav_here();
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('今日热点')));
		$this->assign('ur_here', __('今日热点'));

		$this->display('mobile_news.dwt');
	}

	/**
	 * 添加展示页面
	 */
	public function add() {
		$this->admin_priv('mobile_news_add', ecjia::MSGTYPE_JSON);
		$this->assign('action_link', array('text' => __('今日热点'), 'href' => RC_Uri::url('mobile/admin_mobile_news/init')));
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('添加今日热点')));
		$this->assign('ur_here', __('添加今日热点'));
		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_news/insert'));
		$this->display('mobile_news_edit.dwt');
	}

	/**
	 * 添加执行
	 */
	public function insert() {
		$this->admin_priv('mobile_news_add', ecjia::MSGTYPE_JSON);
		$post = $_POST;
		if (!empty($post)) {
			$group_id = 0;
			foreach ($post['title'] as $key => $val) {
				$image_url = '';
				/* 处理上传的LOGO图片 */
				if ((isset($_FILES['image_url']['error'][$key]) && $_FILES['image_url']['error'][$key] == 0) ||(!isset($_FILES['image_url']['error'][$key]) && isset($_FILES['image_url']['tmp_name'][$key]) && $_FILES['image_url']['tmp_name'][$key] != 'none')) {
					$upload = RC_Upload::uploader('image', array('save_path' => 'data/mobile_news', 'auto_sub_dirs' => false));
					$file = array(
							'name'	=> $_FILES['image_url']['name'][$key],
							'type'	=> $_FILES['image_url']['type'][$key],
							'tmp_name'	=> $_FILES['image_url']['tmp_name'][$key],
							'error'	=> $_FILES['image_url']['error'][$key],
							'size'	=> $_FILES['image_url']['size'][$key]
					);
					$info = $upload->upload($file);
					if (!empty($info)) {
// 						$image_url = $info['savepath'] . '/' . $info['savename'];
						$image_url = $upload->get_position($info);
					} else {
						$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
				} else {
					$this->showmessage(__('上传文件错误！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}

				$data = array (
					'group_id'		=> $group_id,
					'title'			=> $post['title'][$key],
					'description'	=> $post['description'][$key],
					'content_url'	=> $post['content_url'][$key],
					'image'			=> $image_url,
					'type'			=> 'article',
					'create_time'	=> RC_Time::gmtime(),
				);

				if ($key == 0) {
					$group_id = $this->db_mobile_news->insert($data);
				} else {
					$this->db_mobile_news->insert($data);
				}
				ecjia_admin::admin_log($data['title'], 'add', 'mobile_news');
			}
		}

		$links[] = array('text' => __('今日热点列表'), 'href' => RC_Uri::url('mobile/admin_mobile_news/init'));
		$this->showmessage('添加今日热点成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links , 'pjaxurl' => RC_Uri::url('mobile/admin_mobile_news/edit', 'id='.$group_id)));

	}

	/**
	 * 编辑显示页面
	 */
	public function edit() {
		$this->admin_priv('mobile_news_update', ecjia::MSGTYPE_JSON);
		$id = $_GET['id'];
		$mobile_news = $this->db_mobile_news->where(array('id' => $id , 'or', 'group_id' => $id))->order(array('group_id' => 'asc'))->select();

		if (!empty($mobile_news)) {
			foreach ($mobile_news as $key => $val) {
				if ($val['group_id'] == 0) {
					$mobile_news_status = $val['status'];
				}
				if (substr($val['image'], 0, 4) != 'http') {
					$mobile_news[$key]['image'] = RC_Upload::upload_url() . '/' . $val['image'];
				}
			}
		}


		$this->assign('action_link', array('text' => __('今日热点'), 'href' => RC_Uri::url('mobile/admin_mobile_news/init')));
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('编辑今日热点')));
		$this->assign('ur_here', __('编辑今日热点'));
		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_news/update'));
		$this->assign('mobile_news', $mobile_news);
		$this->assign('mobile_news_id', $id);
		$this->assign('mobile_news_status', $mobile_news_status);
		$this->display('mobile_news_edit.dwt');
	}

	/**
	 * 编辑及提交处理
	 */
	public function update() {
		$this->admin_priv('mobile_news_update', ecjia::MSGTYPE_JSON);
		$post = $_POST;
		$group_id = $_POST['group_id'];

		$group_news = $this->db_mobile_news->where(array('id' => $group_id , 'or', 'group_id' => $group_id))->get_field('id', true);

		if (!empty($post)) {
			foreach ($post['title'] as $key => $val) {
				$data = array (
						'group_id'		=> $key == $group_id ? 0 : $group_id,
						'title'			=> $post['title'][$key],
						'description'	=> $post['description'][$key],
						'content_url'	=> $post['content_url'][$key],
						'type'			=> 'article',
				);

				/* 处理上传的LOGO图片 */
				if ((isset($_FILES['image_url']['error'][$key]) && $_FILES['image_url']['error'][$key] == 0) ||(!isset($_FILES['image_url']['error'][$key]) && isset($_FILES['image_url']['tmp_name'][$key]) && $_FILES['image_url']['tmp_name'][$key] != 'none')) {
					$upload = RC_Upload::uploader('image', array('save_path' => 'data/mobile_news', 'auto_sub_dirs' => false));
					$file = array(
						'name'	=> $_FILES['image_url']['name'][$key],
						'type'	=> $_FILES['image_url']['type'][$key],
						'tmp_name'	=> $_FILES['image_url']['tmp_name'][$key],
						'error'	=> $_FILES['image_url']['error'][$key],
						'size'	=> $_FILES['image_url']['size'][$key]
					);
					$info = $upload->upload($file);
					if (!empty($info)) {
						$image = $this->db_mobile_news->where(array('id' => $key))->get_field('image');
						$upload->remove($image);
// 						$image_url = $info['savepath'] . '/' . $info['savename'];
						$image_url = $upload->get_position($info);
						$data = array_merge($data, array('image' => $image_url));
					} else {
						$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
				}

				if (in_array($key, $group_news)) {
					$this->db_mobile_news->where(array('id' => $key))->update($data);
					ecjia_admin::admin_log($data['title'], 'edit', 'mobile_news');
				} else {
					$data = array_merge($data, array('create_time'	=> RC_Time::gmtime()));
					$this->db_mobile_news->insert($data);
					ecjia_admin::admin_log($data['title'], 'edit', 'mobile_news');
				}
			}
		}
		$links[] = array('text' => __('今日热点列表'), 'href' => RC_Uri::url('mobile/admin_mobile_news/init'));
		$this->showmessage('编辑今日热点成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links , 'pjaxurl' => RC_Uri::url('mobile/admin_mobile_news/init')));
	}

	public function remove() {
		$this->admin_priv('mobile_news_delete');
		$id = $_GET['id'];
		$info = $this->db_mobile_news->where(array('id' => $id, 'OR', 'group_id' => $id))->select();
		
		foreach ($info as $v) {
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $v['image']);
		}
		
		$this->db_mobile_news->where(array('id' => $id, 'OR', 'group_id' => $id))->delete();

		$title = $this->db_mobile_news->where(array('id' => $id))->get_field('title');
		ecjia_admin::admin_log($title, 'remove', 'mobile_news');
		$this->showmessage(__('删除今日热点成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	public function issue() {
		$id = $_GET['id'];
		$this->db_mobile_news->where(array('id' => $id, 'group_id'=> 0))->update(array('status' => 1));
		$this->showmessage('发布成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links , 'pjaxurl' => RC_Uri::url('mobile/admin_mobile_news/edit', 'id='.$id)));
	}

	public function unissue() {
		$id = $_GET['id'];
		$this->db_mobile_news->where(array('id' => $id, 'group_id'=> 0))->update(array('status' => 0));
		$this->showmessage('取消发布成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links , 'pjaxurl' => RC_Uri::url('mobile/admin_mobile_news/edit', 'id='.$id)));
	}
}

// end
