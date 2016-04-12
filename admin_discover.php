<?php
/**
 * ECJia百宝箱管理控制器
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_discover extends ecjia_admin {

	private $mobile;

	public function __construct() {
		parent::__construct();

		$this->mobile = RC_Loader::load_app_class('mobile_method');

		if (!ecjia::config(mobile_method::STORAGEKEY_discover_data, ecjia::CONFIG_CHECK)) {
			ecjia_config::instance()->insert_config('hidden', mobile_method::STORAGEKEY_discover_data, serialize(array()), array('type' => 'hidden'));
		}
		RC_Loader::load_app_func('global');
		assign_adminlog_content();

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

		RC_Script::enqueue_script('discover', RC_App::apps_url('statics/js/discover.js' , __FILE__), array(), false, false);

		RC_Script::enqueue_script('bootstrap-placeholder');

		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('百宝箱'), RC_Uri::url('mobile/admin_discover/init')));
	}

	/**
	 * 百宝箱列表页面加载
	 */
	public function init () {
		$this->admin_priv('discover_manage',ecjia::MSGTYPE_JSON);

		ecjia_screen::$current_screen->remove_last_nav_here();
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('百宝箱')));
		$this->assign('ur_here', __('百宝箱'));
		$this->assign('action_link_special', array('text' => __('添加百宝箱'), 'href' => RC_Uri::url('mobile/admin_discover/add')));

		$this->assign('uri', RC_Uri::site_url());

		$playerdb = $this->mobile->discover_data(true);
		$this->assign('playerdb', $playerdb);

		$this->display('discover_list.dwt');
	}

	/**
	 * 添加及提交处理
	 */
	public function add() {
		$this->admin_priv('discover_add',ecjia::MSGTYPE_JSON);

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
			ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('添加百宝箱')));
			$this->assign('ur_here', __('添加百宝箱'));
			$this->assign('form_action', RC_Uri::url('mobile/admin_discover/add'));
			$this->assign('action_link', array('text' => __('百宝箱'), 'href' => RC_Uri::url('mobile/admin_discover/init')));

			$this->display('discover_edit.dwt');
		}
		// 提交表单处理
		elseif ($_POST['step'] == 2) {

			if (!empty($_FILES['img_file_src']['name'])) {
				$upload = RC_Upload::uploader('image', array('save_path' => 'data/discover', 'auto_sub_dirs' => false));
				$info = $upload->upload($_FILES['img_file_src']);
				if (!empty($info)) {
// 					$src = $info['savepath'] . '/' . $info['savename'];
					$src = $upload->get_position($info);
				} else {
					$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} else {
			    $this->showmessage(__('请上传百宝箱图标'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}

			if (empty($_POST['img_url'])) {
				$this->showmessage(__('请填写链接地址'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if (!isset($_POST['img_display'])) {
				$insert_arr = $this->mobile->shortcut_struct(array('src' => $src, 'url' => $_POST['img_url'], 'text' => $_POST['img_text'] ,'display' => 0,'sort' => $_POST['img_sort']));
			} else {
				$insert_arr = $this->mobile->shortcut_struct(array('src' => $src, 'url' => $_POST['img_url'], 'text' => $_POST['img_text'] ,'display' => $_POST['img_display'],'sort' => $_POST['img_sort']));
			}
			$flashdb = $this->mobile->discover_data();
			array_push($flashdb, $insert_arr);

			$id = count($flashdb);
			$flashdb = $this->mobile->shortcut_sort($flashdb);

			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_discover_data, serialize($flashdb));

			$links[] = array('text' => __('百宝箱列表'), 'href' => RC_Uri::url('mobile/admin_discover/init'));

			ecjia_admin::admin_log($_POST['img_text'], 'add', 'mobile_discover');
			$this->showmessage('添加百宝箱成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links , 'pjaxurl' => RC_Uri::url('mobile/admin_discover/add')));
		}
	}

	/**
	 * 编辑及提交处理
	 */
	public function edit() {
		$this->admin_priv('discover_update',ecjia::MSGTYPE_JSON);

		$id = intval($_REQUEST['id']); //取得id
		$flashdb = $this->mobile->discover_data();
		if (isset($flashdb[$id])) {
			$rt = $flashdb[$id];
		} else {
			$links[] = array('text' => __('百宝箱列表'), 'href' => RC_Uri::url('mobile/admin_discover/init'));
		}

		if (empty($_POST['step'])) {
			$rt['img_url']       = $rt['url'];
			$rt['img_display']   = $rt['display'];
			$rt['img_src']       = $rt['src'];
			$rt['img_txt']       = $rt['text'];
			$rt['img_sort']      = empty($rt['sort']) ? 0 : $rt['sort'];
			$rt['id']            = $id;

			ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('编辑百宝箱')));

			$this->assign('ur_here', __('编辑百宝箱'));
			$this->assign('form_action', RC_Uri::url('mobile/admin_discover/edit'));
			$this->assign('action_link', array('text' => __('百宝箱列表'), 'href' => RC_Uri::url('mobile/admin_discover/init')));
			$this->assign('rt', $rt);

			$this->display('discover_edit.dwt');
		}

		// 提交处理
		elseif ($_POST['step'] == 2) {
			// 有上传图片
			if (!empty($_FILES['img_file_src']['name'])) {
				$upload = RC_Upload::uploader('image', array('save_path' => 'data/discover', 'auto_sub_dirs' => false));
				$info = $upload->upload($_FILES['img_file_src']);
				if (!empty($info)) {
// 					$src = $info['savepath'] . '/' . $info['savename'];
					$src = $upload->get_position($info);
				} else {
					$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			// 图片上传不能为空
			elseif (empty($rt['src'])) {
				$this->showmessage(__('请上传百宝箱图标'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}


			if ($src && $rt['src'] != $src) {
// 				@unlink(RC_Upload::upload_path() . $rt['src']);
				$upload->remove($rt['src']);
			} else {
			    $src = $rt['src'];
			}

			$display = $_POST['img_display'];
			if (!isset($display)) {
				$display = 0;
			}
       		$flashdb[$id] = array(
       			'src'	=> $src,
       			'url'	=> $_POST['img_url'],
       			'display'	=> $display,
       			'text'	=> $_POST['img_text'],
       			'sort'	=> $_POST['img_sort']
       		);

       		$flashdb[$id] = $this->mobile->shortcut_struct($flashdb[$id]);
			$flashdb = $this->mobile->shortcut_sort($flashdb);

			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_discover_data, serialize($flashdb));

			ecjia_admin::admin_log($_POST['img_text'], 'edit', 'mobile_discover');
		    $this->showmessage('编辑百宝箱成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links , 'pjaxurl' => RC_Uri::url('mobile/admin_discover/init')));
		}
	}

	/**
	 * 删除百宝箱
	 */
	public function remove() {
		$this->admin_priv('discover_delete');

		$id = intval($_GET['id']);
		$flashdb = $this->mobile->discover_data();
		if (isset($flashdb[$id])) {
			$rt = $flashdb[$id];
		} else {
			$links[] = array('text' => __('百宝箱列表'), 'href' => RC_Uri::url());
			$this->showmessage(__('没有指定的百宝箱！'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
		}

		if (strpos($rt['src'], 'http') === false) {
// 			@unlink(RC_Upload::upload_path() . $rt['src']);
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $rt['src']);
		}

		unset($flashdb[$id]);

		ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_discover_data, serialize($flashdb));

		ecjia_admin::admin_log($rt['text'], 'remove', 'mobile_discover');
		$this->showmessage(__('删除百宝箱成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 编辑百宝箱的排序
	 */
	public function edit_sort() {
		$this->admin_priv('discover_update',ecjia::MSGTYPE_JSON);

		$id    = intval($_POST['pk']);
		$order = intval(trim($_POST['value']));

		if (!is_numeric($order)) {
			$this->showmessage(__('输入格式不正确！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$flashdb = $this->mobile->discover_data();
			$flashdb[$id]['sort'] = $order;

			$flashdb = $this->mobile->shortcut_sort($flashdb);

			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_discover_data, serialize($flashdb));

			$this->showmessage(__('百宝箱列表排序操作成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('mobile/admin_discover/init')) );
		}
	}

	/**
	 * 切换是否显示
	 */
	public function toggle_show() {
		$this->admin_priv('discover_update',ecjia::MSGTYPE_JSON);

		$id     = intval($_POST['id']);
		$val    = intval($_POST['val']);

		$flashdb = $this->mobile->discover_data();
		$flashdb[$id]['display'] = $val;
		$text = $flashdb[$id]['text'];

		if (!empty($text)) {
			$text = '，'.$text;
		}
		$display = $flashdb[$id]['display'];

		$flashdb = $this->mobile->shortcut_sort($flashdb);

		ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_discover_data, serialize($flashdb));

		if ($display == 1) {
			ecjia_admin::admin_log('显示百宝箱'.$text, 'setup', 'mobile_discover');
		} else {
			ecjia_admin::admin_log('隐藏百宝箱'.$text, 'setup', 'mobile_discover');
		}
		$this->showmessage('切换是否显示操作成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content'=> $val));
	}
}

// end
