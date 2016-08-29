<?php
/**
 * ECJia移动端banner管理控制器
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_cycleimage extends ecjia_admin {

	private $mobile;

	public function __construct() {
		parent::__construct();

		$this->mobile = RC_Loader::load_app_class('mobile_method');

		if (!ecjia::config(mobile_method::STORAGEKEY_cycleimage_data, ecjia::CONFIG_CHECK)) {
			ecjia_config::instance()->insert_config('hidden', mobile_method::STORAGEKEY_cycleimage_data, serialize(array()), array('type' => 'hidden'));
		}
		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		/* 加载所需js */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Style::enqueue_style('chosen');

		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('smoke');

		RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('bootstrap-placeholder');
		
		RC_Script::enqueue_script('cycleimage', RC_App::apps_url('statics/js/cycleimage.js', __FILE__), array(), false, false);
		RC_Script::localize_script('cycleimage', 'js_lang', RC_Lang::get('mobile::mobile.js_lang'));

		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.ipad_cycleimage'), RC_Uri::url('mobile/admin_cycleimage/init')));
	}

	/**
	 * 轮播图列表页面加载
	 */
	public function init() {
		$this->admin_priv('cycleimage_manage', ecjia::MSGTYPE_JSON);

		$playerdb = $this->mobile->cycleimage_data(true);

		ecjia_screen::$current_screen->remove_last_nav_here();
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.ipad_cycleimage')));

		ecjia_screen::$current_screen->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('mobile::mobile.open_app_function'),
			'content'	=>
			'<p>'.RC_Lang::get('mobile::mobile.open_discover').'ecjiaopen://app?open_type=discover' .
			'<p>'.RC_Lang::get('mobile::mobile.open_qrcode').'ecjiaopen://app?open_type=qrcode</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_qrshare').'ecjiaopen://app?open_type=qrshare</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_history').'ecjiaopen://app?open_type=history</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_feedback').'ecjiaopen://app?open_type=feedback</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_map').'ecjiaopen://app?open_type=map</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_message').'ecjiaopen://app?open_type=message</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_search').'ecjiaopen://app?open_type=search</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_help').'ecjiaopen://app?open_type=help</p>'
		));
		ecjia_screen::$current_screen->add_help_tab(array(
		    'id'		=> 'managing-pages',
		    'title'		=> RC_Lang::get('mobile::mobile.open_goods_order_user'),
		    'content'	=>
		    '<p>'.RC_Lang::get('mobile::mobile.open_goods_list').'ecjiaopen://app?open_type=goods_list&category_id={id}, {id}'.RC_Lang::get('mobile::mobile.is_category_id').'</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_goods_comment').'ecjiaopen://app?open_type=goods_comment&goods_id={id}, {id}'.RC_Lang::get('mobile::mobile.is_goods_id').'</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_goods_detail').'ecjiaopen://app?open_type=goods_detail&goods_id={id}, {id}'.RC_Lang::get('mobile::mobile.is_goods_id').'</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_oder_list').'ecjiaopen://app?open_type=orders_list</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_order_detail').'ecjiaopen://app?open_type=orders_detail&order_id={id}, {id}'.RC_Lang::get('mobile::mobile.is_order_id').'</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_user_wallet').'ecjiaopen://app?open_type=user_wallet</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_user_address').'ecjiaopen://app?open_type=user_address</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_user_account').'ecjiaopen://app?open_type=user_account</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_user_password').'ecjiaopen://app?open_type=user_password</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_user_center').'ecjiaopen://app?open_type=user_center</p>'
	    ));

		$this->assign('uri', RC_Uri::site_url());
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.cycleimage_list'));
		$this->assign('action_link_special', array('text' => RC_Lang::get('mobile::mobile.add_cycleimage'), 'href' => RC_Uri::url('mobile/admin_cycleimage/add')));
		$this->assign('action', 'admin_cycleimage');
		$this->assign('playerdb', $playerdb);

		$this->display('cycleimage_list.dwt');
	}


	/**
	 * 添加及提交处理
	 */
	public function add() {
		$this->admin_priv('cycleimage_add');

		if (empty($_POST['step'])) {
			$url = isset($_GET['url']) ? trim($_GET['url']) : 'http://';
			$src = isset($_GET['src']) ? trim($_GET['src']) : '';
			$sort = 0;
			$display = 1;
			$rt = array(
				'img_src'	     => $src,
				'img_url'	     => $url,
				'img_sort'	     => $sort,
		        'img_display'    => $display,
			);

			$this->assign('rt', $rt);
			ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.add_cycleimage')));
			$this->assign('ur_here', RC_Lang::get('mobile::mobile.add_cycleimage'));
			$this->assign('form_action', RC_Uri::url('mobile/admin_cycleimage/add'));
			$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.cycleimage_list'), 'href' => RC_Uri::url('mobile/admin_cycleimage/init')));

			$this->display('cycleimage_edit.dwt');
		}
		// 提交表单处理
		elseif ($_POST['step'] == 2) {

			if (!empty($_FILES['img_file_src']['name'])) {
				$upload = RC_Upload::uploader('image', array('save_path' => 'data/afficheimg', 'auto_sub_dirs' => false));
				$info = $upload->upload($_FILES['img_file_src']);
				if (!empty($info)) {
// 					$src = $info['savepath'] . '/' . $info['savename'];
					$src = $upload->get_position($info);
				} else {
					$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} else {
			    $this->showmessage(RC_Lang::get('mobile::mobile.pls_upload_cycyeimage'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}

			if (empty($_POST['img_url'])) {
				$this->showmessage(RC_Lang::get('mobile::mobile.link_url_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if (!isset($_POST['img_display'])) {
				$insert_arr = $this->mobile->shortcut_struct(array('src' => $src, 'url' => $_POST['img_url'], 'text' => $_POST['img_text'] ,'display' => 0,'sort' => $_POST['img_sort']));
			} else {
				$insert_arr = $this->mobile->shortcut_struct(array('src' => $src, 'url' => $_POST['img_url'], 'text' => $_POST['img_text'] ,'display' => $_POST['img_display'],'sort' => $_POST['img_sort']));
			}
			$flashdb = $this->mobile->cycleimage_data();
			array_push($flashdb, $insert_arr);

			$id = count($flashdb);
			$flashdb = $this->mobile->shortcut_sort($flashdb);

			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_cycleimage_data, serialize($flashdb));

			$links[] = array('text' => RC_Lang::get('mobile::mobile.return_cycleimage_list'), 'href' => RC_Uri::url('mobile/admin_cycleimage/init'));

			ecjia_admin::admin_log($_POST['img_text'], 'add', 'mobile_cycleimage');
			$this->showmessage(RC_Lang::get('mobile::mobile.add_cycleimage_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links , 'pjaxurl' => RC_Uri::url('mobile/admin_cycleimage/add')));
		}
	}


	/**
	 * 编辑及提交处理
	 */
	public function edit() {
		$this->admin_priv('cycleimage_manage');

		$id = intval($_REQUEST['id']); //取得id
		$flashdb = $this->mobile->cycleimage_data();
		if (isset($flashdb[$id])) {
			$rt = $flashdb[$id];
		} else {
			$links[] = array('text' => RC_Lang::get('mobile::mobile.cycleimage_list'), 'href' => RC_Uri::url('mobile/admin_cycleimage/init'));
		}

		if (empty($_POST['step'])) {
			$rt['img_url']       = $rt['url'];
			$rt['img_display']   = $rt['display'];
			$rt['img_src']       = $rt['src'];
			$rt['img_txt']       = $rt['text'];
			$rt['img_sort']      = empty($rt['sort']) ? 0 : $rt['sort'];
			$rt['id']            = $id;

			ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.edit_cycleimage')));

			$this->assign('ur_here', RC_Lang::get('mobile::mobile.edit_cycleimage'));
			$this->assign('form_action', RC_Uri::url('mobile/admin_cycleimage/edit'));
			$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.cycleimage_list'), 'href' => RC_Uri::url('mobile/admin_cycleimage/init')));
			$this->assign('rt', $rt);

			$this->display('cycleimage_edit.dwt');
		}

		// 提交处理
		elseif ($_POST['step'] == 2) {
			// 有上传图片
			if (!empty($_FILES['img_file_src']['name'])) {
				$upload = RC_Upload::uploader('image', array('save_path' => 'data/afficheimg', 'auto_sub_dirs' => false));
				$info = $upload->upload($_FILES['img_file_src']);
				if (!empty($info)) {
// 					$src = $info['savepath'] . '/' . $info['savename'];
					$src = $upload->get_position($info);
					$upload->remove($rt['src']);
				} else {
					$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			// 图片上传不能为空
			elseif (empty($rt['src'])) {
				$this->showmessage(RC_Lang::get('mobile::mobile.pls_upload_cycyeimage'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
			    $src = $rt['src'];
			}

			$display = isset($_POST['img_display']) ? 1 : 0;
		
       		$flashdb[$id] = array (
       			'src'		=> $src,
       			'url'		=> $_POST['img_url'],
       			'display'	=> $display,
       			'text'		=> $_POST['img_text'],
       			'sort'		=> $_POST['img_sort']
       		);

       		$flashdb[$id] = $this->mobile->shortcut_struct($flashdb[$id]);
			$flashdb = $this->mobile->shortcut_sort($flashdb);

			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_cycleimage_data, serialize($flashdb));

			ecjia_admin::admin_log($_POST['img_text'], 'edit', 'mobile_cycleimage');
		    $this->showmessage(RC_Lang::get('mobile::mobile.edit_cycleimage_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_cycleimage/init')));
		}
	}

	/**
	 * 删除轮播图
	 */
	public function remove() {
		$this->admin_priv('cycleimage_delete');

		$id = intval($_GET['id']);
		$flashdb = $this->mobile->cycleimage_data();
		if (isset($flashdb[$id])) {
			$rt = $flashdb[$id];
		} else {
			$links[] = array('text' => RC_Lang::get('mobile::mobile.cycleimage_list'), 'href' => RC_Uri::url());
			$this->showmessage(RC_Lang::get('mobile::mobile.cycleimage_empty'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
		}

		if (strpos($rt['src'], 'http') === false) {
// 			@unlink(RC_Upload::upload_path() . $rt['src']);
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $rt['src']);
		}

		unset($flashdb[$id]);

		ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_cycleimage_data, serialize($flashdb));

		ecjia_admin::admin_log($rt['text'], 'remove', 'mobile_cycleimage');
		$this->showmessage(RC_Lang::get('mobile::mobile.drop_cycleimage_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 编辑轮播图的排序
	 */
	public function edit_sort() {
		$this->admin_priv('cycleimage_update');

		$id    = intval($_POST['pk']);
		$order = intval($_POST['value']);

		if (!is_numeric($order)) {
			$this->showmessage(RC_Lang::get('mobile::mobile.format_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$flashdb = $this->mobile->cycleimage_data();
			$flashdb[$id]['sort'] = $order;

			$flashdb = $this->mobile->shortcut_sort($flashdb);
			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_cycleimage_data, serialize($flashdb));

			$this->showmessage(RC_Lang::get('mobile::mobile.order_sort_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('mobile/admin_cycleimage/init')) );
		}
	}

	/**
	 * 切换是否显示
	 */
	public function toggle_show() {
		$this->admin_priv('cycleimage_update');

		$id     = intval($_POST['id']);
		$val    = intval($_POST['val']);

		$flashdb = $this->mobile->cycleimage_data();
		
		$flashdb[$id]['display'] = $val;
		$text = $flashdb[$id]['text'];
		
// 		$flashdb = $this->mobile->shortcut_sort($flashdb);

		ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_cycleimage_data, serialize($flashdb));
		if ($val == 1) {
			ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.display_cycleimage'), $text), 'setup', 'mobile_cycleimage');
		} else {
			ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.hide_cycleimage'), $text), 'setup', 'mobile_cycleimage');
		}
		$this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content'=> $val, 'pjaxurl' => RC_uri::url('mobile/admin_cycleimage/init')));
	}
}

// end