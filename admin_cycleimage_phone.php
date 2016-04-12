<?php
/**
 * ECJia移动端banner管理控制器
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_cycleimage_phone extends ecjia_admin {

	private $mobile;

	public function __construct() {
		parent::__construct();

		$this->mobile = RC_Loader::load_app_class('mobile_method');

		if (!ecjia::config(mobile_method::STORAGEKEY_cycleimage_phone_data, ecjia::CONFIG_CHECK)) {
			ecjia_config::instance()->insert_config('hidden', mobile_method::STORAGEKEY_cycleimage_phone_data, serialize(array()), array('type' => 'hidden'));
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

		RC_Script::enqueue_script('cycleimage', RC_App::apps_url('statics/js/cycleimage.js' , __FILE__), array(), false, false);

		RC_Script::enqueue_script('bootstrap-placeholder');

		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('手机端轮播图'), RC_Uri::url('mobile/admin_cycleimage_phone/init')));
	}

	/**
	 * 轮播图列表页面加载
	 */
	public function init() {
		$this->admin_priv('cycleimage_manage',ecjia::MSGTYPE_JSON);

		$playerdb = $this->mobile->cycleimage_phone_data(true);

		ecjia_screen::$current_screen->remove_last_nav_here();
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('手机端轮播图')));

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
		$this->assign('ur_here', __('轮播图列表'));
		$this->assign('action_link_special', array('text' => __('添加轮播图'), 'href' => RC_Uri::url('mobile/admin_cycleimage_phone/add')));
		$this->assign('action', 'admin_cycleimage_phone');
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
			ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('添加轮播图')));
			$this->assign('ur_here', __('添加轮播图'));
			$this->assign('form_action', RC_Uri::url('mobile/admin_cycleimage_phone/add'));
			$this->assign('action_link', array('text' => __('轮播图列表'), 'href' => RC_Uri::url('mobile/admin_cycleimage_phone/init')));

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
			    $this->showmessage(__('请上传轮播图'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}

			if (empty($_POST['img_url'])) {
				$this->showmessage(__('请填写链接地址'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if (!isset($_POST['img_display'])) {
				$insert_arr = $this->mobile->shortcut_struct(array('src' => $src, 'url' => $_POST['img_url'], 'text' => $_POST['img_text'] ,'display' => 0,'sort' => $_POST['img_sort']));
			} else {
				$insert_arr = $this->mobile->shortcut_struct(array('src' => $src, 'url' => $_POST['img_url'], 'text' => $_POST['img_text'] ,'display' => $_POST['img_display'],'sort' => $_POST['img_sort']));
			}
			$flashdb = $this->mobile->cycleimage_phone_data();
			array_push($flashdb, $insert_arr);

			$id = count($flashdb);
			$flashdb = $this->mobile->shortcut_sort($flashdb);

			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_cycleimage_phone_data, serialize($flashdb));

			$links[] = array('text' => __('轮播图列表'), 'href' => RC_Uri::url('mobile/admin_cycleimage_phone/init'));

			ecjia_admin::admin_log($_POST['img_text'], 'add', 'mobile_cycleimage');
			$this->showmessage('添加轮播图成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links , 'pjaxurl' => RC_Uri::url('mobile/admin_cycleimage_phone/add')));
		}
	}


	/**
	 * 编辑及提交处理
	 */
	public function edit() {
		$this->admin_priv('cycleimage_manage');

		$id = intval($_REQUEST['id']); //取得id
		$flashdb = $this->mobile->cycleimage_phone_data();
		if (isset($flashdb[$id])) {
			$rt = $flashdb[$id];
		} else {
			$links[] = array('text' => __('轮播图列表'), 'href' => RC_Uri::url('mobile/admin_cycleimage_phone/init'));
		}

		if (empty($_POST['step'])) {
			$rt['img_url']       = $rt['url'];
			$rt['img_display']   = $rt['display'];
			$rt['img_src']       = $rt['src'];
			$rt['img_txt']       = $rt['text'];
			$rt['img_sort']      = empty($rt['sort']) ? 0 : $rt['sort'];
			$rt['id']            = $id;

			ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('编辑轮播图')));

			$this->assign('ur_here', __('编辑轮播图'));
			$this->assign('form_action', RC_Uri::url('mobile/admin_cycleimage_phone/edit'));
			$this->assign('action_link', array('text' => __('轮播图列表'), 'href' => RC_Uri::url('mobile/admin_cycleimage_phone/init')));
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
				$this->showmessage(__('请上传轮播图'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
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

			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_cycleimage_phone_data, serialize($flashdb));

			ecjia_admin::admin_log($_POST['img_text'], 'edit', 'mobile_cycleimage');
		    $this->showmessage('编辑轮播图成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_cycleimage_phone/init')));
		}
	}

	/**
	 * 删除轮播图
	 */
	public function remove() {
		$this->admin_priv('cycleimage_delete');

		$id = intval($_GET['id']);
		$flashdb = $this->mobile->cycleimage_phone_data();
		if (isset($flashdb[$id])) {
			$rt = $flashdb[$id];
		} else {
			$links[] = array('text' => __('轮播图列表'), 'href' => RC_Uri::url());
			$this->showmessage(__('没有指定的轮播图！'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
		}

		if (strpos($rt['src'], 'http') === false) {
// 			@unlink(RC_Upload::upload_path() . $rt['src']);
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $rt['src']);
		}

		unset($flashdb[$id]);

		ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_cycleimage_phone_data, serialize($flashdb));

		ecjia_admin::admin_log($rt['text'], 'remove', 'mobile_cycleimage');
		$this->showmessage(__('删除轮播图成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 编辑轮播图的排序
	 */
	public function edit_sort() {
		$this->admin_priv('cycleimage_update');

		$id    = intval($_POST['pk']);
		$order = intval($_POST['value']);

		if (!is_numeric($order)) {
			$this->showmessage(__('输入格式不正确！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$flashdb = $this->mobile->cycleimage_phone_data();
			$flashdb[$id]['sort'] = $order;

			$flashdb = $this->mobile->shortcut_sort($flashdb);

			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_cycleimage_phone_data, serialize($flashdb));

			$this->showmessage('轮播图列表排序操作成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('mobile/admin_cycleimage_phone/init')) );
		}
	}

	/**
	 * 切换是否显示
	 */
	public function toggle_show() {
		$this->admin_priv('cycleimage_update');

		$id     = intval($_POST['id']);
		$val    = intval($_POST['val']);

		$flashdb = $this->mobile->cycleimage_phone_data();
		$flashdb[$id]['display'] = $val;

		$text = $flashdb[$id]['text'];
		if (!empty($text)) {
			$text = '，'.$text;
		}
		$display = $flashdb[$id]['display'];

		$flashdb = $this->mobile->shortcut_sort($flashdb);

		ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_cycleimage_phone_data, serialize($flashdb));

		if ($display == 1) {
			ecjia_admin::admin_log('显示轮播图 '.$text, 'setup', 'mobile_cycleimage');
		} else {
			ecjia_admin::admin_log('隐藏轮播图 '.$text, 'setup', 'mobile_cycleimage');
		}
		$this->showmessage('切换是否显示操作成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content'=> $val));
	}
}

// end
