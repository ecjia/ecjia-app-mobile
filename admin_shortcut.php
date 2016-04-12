<?php
/**
 * ECJia快捷菜单管理控制器
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_shortcut extends ecjia_admin {

	private $mobile;

	public function __construct() {
		parent::__construct();

		$this->mobile = RC_Loader::load_app_class('mobile_method');

		if (!ecjia::config(mobile_method::STORAGEKEY_shortcut_data, ecjia::CONFIG_CHECK)) {
			ecjia_config::instance()->insert_config('hidden', mobile_method::STORAGEKEY_shortcut_data, serialize(array()), array('type' => 'hidden'));
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

		RC_Script::enqueue_script('shortcut', RC_App::apps_url('statics/js/shortcut.js' , __FILE__), array(), false, false);

		RC_Script::enqueue_script('bootstrap-placeholder');

		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('快捷菜单'), RC_Uri::url('mobile/admin_shortcut/init')));
	}

	/**
	 * 快捷菜单列表页面加载
	 */
	public function init() {
		$this->admin_priv('shortcut_manage',ecjia::MSGTYPE_JSON);

		$playerdb = $this->mobile->shortcut_data(true);

		ecjia_screen::$current_screen->remove_last_nav_here();
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('快捷菜单')));

		ecjia_screen::$current_screen->add_help_tab( array(
		'id'		=> 'overview',
		'title'		=> __('打开应用功能'),
		'content'	=>
		'<p>打开发现: ecjiaopen://app?open_type=discover' .
		'<p>打开二维码扫描: ecjiaopen://app?open_type=qrcode</p>' .
		'<p>打开二维码分享: ecjiaopen://app?open_type=qrshare</p>' .
		'<p>打开浏览记录: ecjiaopen://app?open_type=history</p>' .
		'<p>打开咨询: ecjiaopen://app?open_type=feedback</p>' .
		'<p>打开地图: ecjiaopen://app?open_type=map</p>' .
		'<p>打开消息中心: ecjiaopen://app?open_type=message</p>' .
		'<p>打开搜索: ecjiaopen://app?open_type=search</p>' .
		'<p>打开帮助中心: ecjiaopen://app?open_type=help</p>'
		    ) );
	    ecjia_screen::$current_screen->add_help_tab( array(
	    'id'		=> 'managing-pages',
	    'title'		=> __('打开商品订单用户'),
	    'content'	=>
	    '<p>打开商品列表: ecjiaopen://app?open_type=goods_list&category_id={id}, {id}是分类的ID</p>' .
		'<p>打开商品评论: ecjiaopen://app?open_type=goods_comment&goods_id={id}, {id}是商品的ID</p>' .
		'<p>打开商品祥情: ecjiaopen://app?open_type=goods_detail&goods_id={id}, {id}是商品的ID</p>' .
		'<p>打开我的订单: ecjiaopen://app?open_type=orders_list</p>' .
		'<p>打开订单祥情: ecjiaopen://app?open_type=orders_detail&order_id={id}, {id}是订单的ID</p>' .
		'<p>打开我的钱包: ecjiaopen://app?open_type=user_wallet</p>' .
		'<p>打开地址管理: ecjiaopen://app?open_type=user_address</p>' .
		'<p>打开账户余额: ecjiaopen://app?open_type=user_account</p>' .
		'<p>打开修改密码: ecjiaopen://app?open_type=user_password</p>' .
		'<p>打开用户中心: ecjiaopen://app?open_type=user_center</p>'
	        ) );

		$this->assign('uri', RC_Uri::site_url());
		$this->assign('ur_here', __('快捷菜单'));
		$this->assign('action_link_special', array('text' => __('添加快捷菜单'), 'href' => RC_Uri::url('mobile/admin_shortcut/add')));

		$this->assign('playerdb', $playerdb);

		$this->display('shortcut_list.dwt');
	}


	/**
	 * 添加及提交处理
	 */
	public function add() {
		$this->admin_priv('shortcut_add',ecjia::MSGTYPE_JSON);

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
			ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('添加快捷菜单')));
			$this->assign('ur_here', __('添加快捷菜单'));
			$this->assign('form_action', RC_Uri::url('mobile/admin_shortcut/add'));
			$this->assign('action_link', array('text' => __('快捷菜单列表'), 'href' => RC_Uri::url('mobile/admin_shortcut/init')));

			$this->display('shortcut_edit.dwt');
		}
		// 提交表单处理
		elseif ($_POST['step'] == 2) {

			if (!empty($_FILES['img_file_src']['name'])) {
				$upload = RC_Upload::uploader('image', array('save_path' => 'data/shortcut', 'auto_sub_dirs' => false));
				$info = $upload->upload($_FILES['img_file_src']);
				if (!empty($info)) {
// 					$src = $info['savepath'] . '/' . $info['savename'];
					$src = $upload->get_position($info);
				} else {
					$this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} else {
			    $this->showmessage(__('请上传快捷菜单图标'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}

			if (empty($_POST['img_url'])) {
				$this->showmessage(__('请填写链接地址'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if (!isset($_POST['img_display'])) {
				$insert_arr = $this->mobile->shortcut_struct(array('src' => $src, 'url' => $_POST['img_url'], 'text' => $_POST['img_text'] ,'display' => 0,'sort' => $_POST['img_sort']));
			} else {
				$insert_arr = $this->mobile->shortcut_struct(array('src' => $src, 'url' => $_POST['img_url'], 'text' => $_POST['img_text'] ,'display' => $_POST['img_display'],'sort' => $_POST['img_sort']));
			}
			$flashdb = $this->mobile->shortcut_data();
			array_push($flashdb, $insert_arr);

			$id = count($flashdb);
			$flashdb = $this->mobile->shortcut_sort($flashdb);

			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_shortcut_data, serialize($flashdb));

			$links[] = array('text' => __('快捷菜单列表'), 'href' => RC_Uri::url('mobile/admin_shortcut/init'));

			ecjia_admin::admin_log($_POST['img_text'], 'add', 'mobile_shortcut');
			$this->showmessage('添加快捷菜单成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links , 'pjaxurl' => RC_Uri::url('mobile/admin_shortcut/add')));
		}
	}


	/**
	 * 编辑及提交处理
	 */
	public function edit() {
		$this->admin_priv('shortcut_update',ecjia::MSGTYPE_JSON);

		$id = intval($_REQUEST['id']); //取得id
		$flashdb = $this->mobile->shortcut_data();
		if (isset($flashdb[$id])) {
			$rt = $flashdb[$id];
		} else {
			$links[] = array('text' => __('快捷菜单列表'), 'href' => RC_Uri::url('mobile/admin_shortcut/init'));
		}

		if (empty($_POST['step'])) {
			$rt['img_url']       = $rt['url'];
			$rt['img_display']   = $rt['display'];
			$rt['img_src']       = $rt['src'];
			$rt['img_txt']       = $rt['text'];
			$rt['img_sort']      = empty($rt['sort']) ? 0 : $rt['sort'];
			$rt['id']            = $id;

			ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('编辑快捷菜单')));

			$this->assign('ur_here', __('编辑快捷菜单'));
			$this->assign('form_action', RC_Uri::url('mobile/admin_shortcut/edit'));
			$this->assign('action_link', array('text' => __('快捷菜单列表'), 'href' => RC_Uri::url('mobile/admin_shortcut/init')));
			$this->assign('rt', $rt);

			$this->display('shortcut_edit.dwt');
		}

		// 提交处理
		elseif ($_POST['step'] == 2) {
			// 有上传图片
			if (!empty($_FILES['img_file_src']['name'])) {
				$upload = RC_Upload::uploader('image', array('save_path' => 'data/shortcut', 'auto_sub_dirs' => false));
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
				$this->showmessage(__('请上传快捷菜单图标'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$src = $rt['src'];
			}
			
			$display = isset($_POST['img_display']) ? 1 : 0;
       		$flashdb[$id] = array (
       			'src'	=> $src,
       			'url'	=> $_POST['img_url'],
       			'display'	=> $display,
       			'text'	=> $_POST['img_text'],
       			'sort'	=> $_POST['img_sort']
       		);

       		$flashdb[$id] = $this->mobile->shortcut_struct($flashdb[$id]);
			$flashdb = $this->mobile->shortcut_sort($flashdb);

			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_shortcut_data, serialize($flashdb));

			ecjia_admin::admin_log($_POST['img_text'], 'edit', 'mobile_shortcut');
		    $this->showmessage('编辑快捷菜单成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_shortcut/init')));
		}
	}

	/**
	 * 删除快捷菜单
	 */
	public function remove() {
		$this->admin_priv('shortcut_delete',ecjia::MSGTYPE_JSON);

		$id = intval($_GET['id']);
		$flashdb = $this->mobile->shortcut_data();
		if (isset($flashdb[$id])) {
			$rt = $flashdb[$id];
		} else {
			$links[] = array('text' => __('快捷菜单列表'), 'href' => RC_Uri::url());
			$this->showmessage(__('没有指定的快捷菜单！'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
		}

		if (strpos($rt['src'], 'http') === false) {
// 			@unlink(RC_Upload::upload_path() . $rt['src']);
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $rt['src']);
		}

		unset($flashdb[$id]);

		ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_shortcut_data, serialize($flashdb));

		ecjia_admin::admin_log($rt['text'], 'remove', 'mobile_shortcut');
		$this->showmessage(__('删除快捷菜单成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 编辑快捷菜单的排序
	 */
	public function edit_sort() {
		$this->admin_priv('shortcut_update',ecjia::MSGTYPE_JSON);

		$id    = intval($_POST['pk']);
		$order = intval(trim($_POST['value']));

		if (!is_numeric($order)) {
			$this->showmessage(__('输入格式不正确！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$flashdb = $this->mobile->shortcut_data();
			$flashdb[$id]['sort'] = $order;

			$flashdb = $this->mobile->shortcut_sort($flashdb);

			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_shortcut_data, serialize($flashdb));

			$this->showmessage('快捷菜单列表排序操作成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('mobile/admin_shortcut/init')) );
		}
	}

	/**
	 * 切换是否显示
	 */
	public function toggle_show() {
		$this->admin_priv('shortcut_update',ecjia::MSGTYPE_JSON);

		$id     = intval($_POST['id']);
		$val    = intval($_POST['val']);

		$flashdb = $this->mobile->shortcut_data();

		$flashdb[$id]['display'] = $val;
		$text = $flashdb[$id]['text'];

		if (!empty($text)) {
			$text = '，'.$text;
		}
		$display = $flashdb[$id]['display'];

		$flashdb = $this->mobile->shortcut_sort($flashdb);
		ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_shortcut_data, serialize($flashdb));

		if ($display == 1) {
			ecjia_admin::admin_log('显示快捷菜单'.$text, 'setup', 'mobile_shortcut');
		} else {
			ecjia_admin::admin_log('隐藏快捷菜单'.$text, 'setup', 'mobile_shortcut');
		}

		$this->showmessage('切换是否显示操作成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content'=> $val));
	}
}

// end
