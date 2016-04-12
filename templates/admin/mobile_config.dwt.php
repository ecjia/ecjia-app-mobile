<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.config.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid">
	<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
		<div class="span12">
			<div class="tabbable tabs-left">
				<ul class="nav nav-tabs tab_merchants_nav">
					<li class="active"><a href="#tab1" data-toggle="tab">{t}基本信息{/t}</a></li>
					<li><a href="#touch" data-toggle="tab">{t}微商城设置{/t}</a></li>
					<li><a href="#load_app" data-toggle="tab">{t}APP下载地址{/t}</a></li>
					<li><a href="#adsense" data-toggle="tab">{t}移动广告位设置{/t}</a></li>
					<li><a href="#mobile_login" data-toggle="tab">{t}登录页色值设置{/t}</a></li>
					<li><a href="#hot_city" data-toggle="tab">{t}热门城市配置{/t}</a></li>
					<li><a href="#message_notice" data-toggle="tab">{t}消息提醒{/t}</a></li>
					<li><a href="#integral_manage" data-toggle="tab">{t}积分设置{/t}</a></li>
				</ul>
				<div class="tab-content tab_merchants">
					<div class="tab-pane active" id="tab1">
						<div class="control-group formSep">
							<label class="control-label">{t}移动应用 Logo：{/t}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_app_icon}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_app_icon}" alt="{t}暂无图片{/t}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{t}浏览{/t}</span>
									<span class="fileupload-exists">{t}修改{/t}</span>
									<input type="file" name="mobile_app_icon"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{t}您确定要删除此文件吗？{/t}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_app_icon')}" {if $mobile_app_icon}data-removefile="true"{/if}>{t}删除{/t}</a>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}移动应用简介：{/t}</label>
							<div class="controls">
								<input type='text' name='shop_app_description' value='{$shop_app_description}'>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}红包使用说明：{/t}</label>
							<div class="controls">
								<select name='bonus_readme' class="artilce_list">
									<!-- {if !$bonus_readme.title} -->
										<option value='-1'>{t}请选择...{/t}</option>
									<!-- {else} -->
										<option value="{$bonus_readme.id}">{$bonus_readme.title}</option>
									<!-- {/if} -->
								</select>
								<input type='text' name='article_search' class='m_l5 keywords'/>
								<input type='button' class='btn article_search' value='搜索' data-url="{url path='mobile/admin_config/search_article'}"/>
								<span class="help-block">{t}请选择一篇文章，作为您的红包使用说明{/t}</span>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}咨询默认回复设置：{/t}</label>
							<div class="controls">
								<input type='text' name='mobile_feedback_autoreply' value='{$mobile_feedback_autoreply}'>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}PC商城地址：{/t}</label>
							<div class="controls">
								<input type='text' name='shop_pc_url' value='{$shop_pc_url}'>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="touch">
						<div class="control-group formSep">
							<label class="control-label">{t}是否开启微商城：{/t}</label>
							<div class="controls">
								<div id="info-toggle-button">
					                <input class="nouniform" name="wap_config" type="checkbox"  {if $wap_config eq 1}checked="checked"{/if}  value="1"/>
					            </div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}微商城 Logo：{/t}</label>
							<div class="controls">
								<div class="fileupload {if $wap_logo}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$wap_logo}" alt="{t}暂无图片{/t}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{t}浏览{/t}</span>
									<span class="fileupload-exists">{t}修改{/t}</span>
									<input type="file" name="wap_logo"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{t}您确定要删除此文件吗？{/t}" data-href="{RC_Uri::url('mobile/admin_config/del','code=wap_logo')}" {if $mobile_pad_login_bgimage}data-removefile="true"{/if}>{t}删除{/t}</a>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}微商城地址：{/t}</label>
							<div class="controls">
								<input type='text' name='shop_touch_url' value='{$shop_touch_url}'>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="load_app">
						<div class="control-group formSep">
							<label class="control-label">{t}iPhone下载二维码：{/t}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_iphone_qr_code}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_iphone_qr_code}" alt="{t}暂无图片{/t}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{t}浏览{/t}</span>
									<span class="fileupload-exists">{t}修改{/t}</span>
									<input type="file" name="mobile_iphone_qr_code"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{t}您确定要删除此文件吗？{/t}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_iphone_qr_code')}" {if $mobile_iphone_qr_code}data-removefile="true"{/if}>{t}删除{/t}</a>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}iPhone下载地址：{/t}</label>
							<div class="controls">
								<input type='text' name='shop_iphone_download' value='{$shop_iphone_download}'>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}Android下载二维码：{/t}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_android_qr_code}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_android_qr_code}" alt="{t}暂无图片{/t}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{t}浏览{/t}</span>
									<span class="fileupload-exists">{t}修改{/t}</span>
									<input type="file" name="mobile_android_qr_code"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{t}您确定要删除此文件吗？{/t}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_android_qr_code')}" {if $mobile_android_qr_code}data-removefile="true"{/if}>{t}删除{/t}</a>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}Android下载地址：{/t}</label>
							<div class="controls">
								<input type='text' name='shop_android_download' value='{$shop_android_download}'>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}iPad下载二维码：{/t}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_ipad_qr_code}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_ipad_qr_code}" alt="{t}暂无图片{/t}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{t}浏览{/t}</span>
									<span class="fileupload-exists">{t}修改{/t}</span>
									<input type="file" name="mobile_ipad_qr_code"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{t}您确定要删除此文件吗？{/t}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_ipad_qr_code')}" {if $mobile_ipad_qr_code}data-removefile="true"{/if}>{t}删除{/t}</a>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}iPad下载地址：{/t}</label>
							<div class="controls">
								<input type='text' name='shop_ipad_download' value='{$shop_ipad_download}'>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}掌柜UrlScheme设置：{/t}</label>
							<div class="controls">
								<input type='text' name='mobile_shopkeeper_urlscheme' value='{$mobile_shopkeeper_urlscheme}'>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}商城UrlScheme设置：{/t}</label>
							<div class="controls">
								<input type='text' name='mobile_shop_urlscheme' value='{$mobile_shop_urlscheme}'>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="adsense">
						<div class="control-group formSep edit-page">
							<label class="control-label">{t}移动启动页广告图：{/t}</label>
							<div class="controls">
								<select name='mobile_launch_adsense'>
									<option value='0'>{t}请选择...{/t}</option>
									<!-- {foreach from=$ad_position_list item=list} -->
										<option value="{$list.position_id}" {if $list.position_id eq $mobile_launch_adsense}selected{/if}>{$list.position_name}</option>
									<!-- {/foreach} -->
								</select>
								<span class="help-block">{t}请选择所需展示的广告位。{/t}</span>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}移动首页广告组：{/t}</label>
							<div class="controls control-group draggable">
								<div class="ms-container span6" id="ms-custom-navigation">
									<div class="ms-selectable">
										<div class="search-header">
											<input class="span12" id="ms-search" type="text" placeholder="{t}筛选搜索到的应用名称{/t}" autocomplete="off">
										</div>
										<ul class="ms-list nav-list-ready select_adsense_group">
											<!-- {foreach from=$ad_position_list item=list} -->
											<li data-id="{$list.position_id}" id="position_id_{$list.position_id}" class="ms-elem-selectable isShow"><span>{$list.position_name}</span></li>
											<!-- {foreachelse}-->
											<li class="ms-elem-selectable disabled"><span>暂无内容</span></li>
											<!-- {/foreach} -->
										</ul>
									</div>
									<div class="ms-selection">
										<div class="custom-header custom-header-align">所选广告位</div>
										<ul class="ms-list nav-list-content">
											<!-- {foreach from=$mobile_home_adsense_group item=item key=key} -->
											<li class="ms-elem-selection">
												<input type="hidden" value="{$item.position_id}" name="mobile_home_adsense_group[]" />
												<!-- {$item.position_name} -->
												<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span>
											</li>
											<!-- {/foreach} -->
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="control-group formSep edit-page">
							<label class="control-label">{t}首页主题类设置：{/t}</label>
							<div class="controls">
								<select name='mobile_topic_adsense'>
									<option value='0'>{t}请选择...{/t}</option>
									<!-- {foreach from=$ad_position_list item=list} -->
										<option value="{$list.position_id}" {if $list.position_id eq $mobile_topic_adsense}selected{/if}>{$list.position_name}</option>
									<!-- {/foreach} -->
								</select>
								<span class="help-block">{t}请选择广告位，用来显示首页主题类内容{/t}</span>
							</div>
						</div>
						<div class="control-group formSep edit-page">
							<label class="control-label">{t}TV首页大图广告组：{/t}</label>
							<div class="controls">
								<select name='mobile_tv_big_adsense'>
									<option value='0'>{t}请选择...{/t}</option>
									<!-- {foreach from=$ad_position_list item=list} -->
										<option value="{$list.position_id}" {if $list.position_id eq $mobile_tv_big_adsense}selected{/if}>{$list.position_name}</option>
									<!-- {/foreach} -->
								</select>
								<span class="help-block">{t}请选择所需展示的广告位。{/t}</span>
							</div>
						</div>
						<div class="control-group formSep edit-page">
							<label class="control-label">{t}TV首页小图广告组：{/t}</label>
							<div class="controls">
								<select name='mobile_tv_small_adsense'>
									<option value='0'>{t}请选择...{/t}</option>
									<!-- {foreach from=$ad_position_list item=list} -->
										<option value="{$list.position_id}" {if $list.position_id eq $mobile_tv_small_adsense}selected{/if}>{$list.position_name}</option>
									<!-- {/foreach} -->
								</select>
								<span class="help-block">{t}请选择所需展示的广告位。{/t}</span>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="mobile_login">
						<h3 class="heading">手机端登录页设置</h3>
						<div class="control-group formSep">
							<label class="control-label">{t}手机端登录页前景色：{/t}</label>
							<div class="controls">
								<div class="input-append color" data-color="{$mobile_phone_login_fgcolor}">
									<input class="w100" name="mobile_phone_login_fgcolor" type="text" value="{$mobile_phone_login_fgcolor}">
									<span class="add-on">
										<i class="dft_color" style='margin-top: 2px;'></i>
									</span>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}手机端登录页背景色：{/t}</label>
							<div class="controls">
								<div class="input-append color" data-color="{$mobile_phone_login_bgcolor}">
									<input class="w100" name="mobile_phone_login_bgcolor" type="text" value="{$mobile_phone_login_bgcolor}">
									<span class="add-on">
										<i class="dft_color" style='margin-top: 2px;'></i>
									</span>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}手机端登录页背景图片：{/t}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_phone_login_bgimage}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_phone_login_bgimage}" alt="{t}暂无图片{/t}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{t}浏览{/t}</span>
									<span class="fileupload-exists">{t}修改{/t}</span>
									<input type="file" name="mobile_phone_login_bgimage"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{t}您确定要删除此文件吗？{/t}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_phone_login_bgimage')}" {if $mobile_phone_login_bgimage}data-removefile="true"{/if}>{t}删除{/t}</a>
								</div>
							</div>
						</div>
						<h3 class="heading">Pad登录页设置</h3>
						<div class="control-group formSep">
							<label class="control-label">{t}Pad登录页前景色：{/t}</label>
							<div class="controls">
								<div class="input-append color" data-color="{$mobile_pad_login_fgcolor}">
									<input class="w100" name="mobile_pad_login_fgcolor" type="text" value="{$mobile_pad_login_fgcolor}">
									<span class="add-on">
										<i class="dft_color" style='margin-top: 2px;'></i>
									</span>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}Pad登录页背景色：{/t}</label>
							<div class="controls">
								<div class="input-append color" data-color="{$mobile_pad_login_bgcolor}">
									<input class="w100" name="mobile_pad_login_bgcolor" type="text" value="{$mobile_pad_login_bgcolor}">
									<span class="add-on">
										<i class="dft_color" style='margin-top: 2px;'></i>
									</span>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}Pad登录页背景图片：{/t}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_pad_login_bgimage}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_pad_login_bgimage}" alt="{t}暂无图片{/t}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{t}浏览{/t}</span>
									<span class="fileupload-exists">{t}修改{/t}</span>
									<input type="file" name="mobile_pad_login_bgimage"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{t}您确定要删除此文件吗？{/t}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_pad_login_bgimage')}" {if $mobile_pad_login_bgimage}data-removefile="true"{/if}>{t}删除{/t}</a>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="hot_city">
						<div class="control-group formSep">
							<label class="control-label">{t}已选择的热门城市：{/t}</label>
							<div class="controls selected_area chk_radio">
								<!-- {foreach from=$mobile_recommend_city item=region key=id} -->
								<input class="uni_style" type="checkbox" name="regions[]" value="{$id}" checked="checked" /> <span class="m_r10">{$region}&nbsp;&nbsp;</span>
								<!-- {/foreach} -->
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}请选择热门城市：{/t}</label>
							<div class="controls">
								<div class="ms-container ms-shipping span12" id="ms-custom-navigation">
									<div class="ms-selectable ms-mobile-selectable span2">
										<div class="search-header">
											<input class="span12" type="text" placeholder="搜索的国家名称" autocomplete="off" id="selCountry" />
										</div>
										<ul class="ms-list ms-list-mobile nav-list-ready selCountry" data-url="{url path='shipping/region/init' args='target=selProvinces&type=1'}" data-next="selProvinces">
											<!-- {foreach from=$countries item=country key=key} -->
											<li class="ms-elem-selectable select_hot_city" data-val="{$country.region_id}"><span>{$country.region_name|escape:html}</span></li>
											<!-- {foreachelse} -->
											<li class="ms-elem-selectable select_hot_city" data-val="0"><span>{t}没有国家地区可选…{/t}</span></li>
											<!-- {/foreach} -->
										</ul>
									</div>
									<div class="ms-selectable ms-mobile-selectable span2">
										<div class="search-header">
											<input class="span12" type="text" placeholder="搜索的省份名称" autocomplete="off" id="selProvinces" />
										</div>
										<ul class="ms-list ms-list-mobile nav-list-ready selProvinces" data-url="{url path='shipping/region/init' args='target=selCities&type=2'}" data-next="selCities">
											<li class="ms-elem-selectable select_hot_city" data-val="0"><span>{t}请先选择省份名称…{/t}</span></li>
										</ul>
									</div>
									<div class="ms-selectable ms-mobile-selectable span2">
										<div class="search-header">
											<input class="span12" type="text" placeholder="搜索的市/区名称" autocomplete="off" id="selCities" />
										</div>
										<ul class="ms-list ms-list-mobile nav-list-ready selCities">
											<li class="ms-elem-selectable select_hot_city" data-val="0"><span>{t}请先选择市/区名称…{/t}</span></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane edit-page" id="message_notice">
						<div class="control-group formSep">
							<label class="control-label">{t}提醒卖家发货：{/t}</label>
							<div class="controls chk_radio">
								<input type='radio' name='remind_seller_ship' value='2'>短信提醒<input type='radio' name='remind_seller_ship' value='1'>推送提醒<input type='radio' name='remind_seller_ship' value='0'>不提醒
							</div>
						</div>
					</div>
					<div class="tab-pane" id="integral_manage">
						<h3 class="heading">签到送积分</h3>
						<div class="control-group formSep">
							<label class="control-label">{t}是否开启签到送：{/t}</label>
							<div class="controls">
								<div id="is_open_checkin">
					                <input class="nouniform" name="checkin_award_open" type="checkbox"  {if $checkin_award_open eq 1}checked="checked"{/if}  value="1"/>
					            </div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}签到送类型：{/t}</label>
							<div class="controls">
								<select name='checkin_award_type'>
									<option value="integral">送积分</option>
								</select>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}签到送额度：{/t}</label>
							<div class="controls">
								<input type='text' name='checkin_award' value='{$checkin_award}'>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}连续签到天数：{/t}</label>
							<div class="controls">
								<input type='text' name='checkin_extra_day' value='{$checkin_extra_day}'>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}连续签到送额度：{/t}</label>
							<div class="controls">
								<input type='text' name='checkin_extra_award' value='{$checkin_extra_award}'>
							</div>
						</div>
						<h3 class="heading">评论送积分</h3>
						<div class="control-group formSep">
							<label class="control-label">{t}是否开启评论送：{/t}</label>
							<div class="controls">
								<div id="is_open_comment_integral">
					                <input class="nouniform" name="comment_award_open" type="checkbox"  {if $comment_award_open eq 1}checked="checked"{/if}  value="1"/>
					            </div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}评论一次可获得的奖励：{/t}</label>
							<div class="controls">
								<input type='text' name='comment_award' value='{$comment_award}'>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label"><strong>{t}会员等级{/t}</strong></label>
							<label class="control-label">
								<strong>评价后可获得奖励</strong>
							</label>
						</div>
						<!-- {foreach from=$user_rank_list item=item} -->
						<div class="control-group">
							<label class="control-label">{t}{$item.rank_name}：{/t}</label>
							<div class="controls">
								<input type='text' name="comment_award_rules[{$item.rank_id}]" value="{$item.comment_award}">
							</div>
						</div>
						<!-- {/foreach} -->
						<div class="control-group">
							<div class="controls">
								<span class="help-block">{t}不用次规则这设置为0或不填，否则已该规则为准！{/t}</span>
							</div>
						</div>
						
					</div>
					<div class="control-group">
						<div class="controls">
							<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<!-- {/block} -->