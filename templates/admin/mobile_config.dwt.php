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
					<li class="active"><a href="#tab1" data-toggle="tab">{lang key='mobile::mobile.basic_info'}</a></li>
					{if 0}<li><a href="#touch" data-toggle="tab">{lang key='mobile::mobile.touch_set'}</a></li>{/if}
					<li><a href="#load_app" data-toggle="tab">{lang key='mobile::mobile.download_url'}</a></li>
					<li><a href="#adsense" data-toggle="tab">{lang key='mobile::mobile.adsense_set'}</a></li>
					{if 0}<li><a href="#tv_adsense" data-toggle="tab">TV广告位设置</a></li>{/if}
					<li><a href="#mobile_login" data-toggle="tab">{lang key='mobile::mobile.mobile_login'}</a></li>
					<li><a href="#hot_city" data-toggle="tab">{lang key='mobile::mobile.hot_city_set'}</a></li>
					<li><a href="#message_notice" data-toggle="tab">{lang key='mobile::mobile.message_notice'}</a></li>
					<li><a href="#app_screenshots" data-toggle="tab">{lang key='mobile::mobile.app_screenshots'}</a></li>
<!-- 					<li><a href="#integral_manage" data-toggle="tab">{lang key='mobile::mobile.integral_manage'}</a></li> -->
				</ul>
				<div class="tab-content tab_merchants">
					<div class="tab-pane active" id="tab1">
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.mobile_app_name'}</label>
							<div class="controls">
								<input type="text" name="mobile_app_name" value="{$mobile_app_name}">
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.label_mobile_logo'}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_app_icon}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_app_icon}" alt="{lang key='mobile::mobile.no_image'}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
									<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
									<input type="file" name="mobile_app_icon"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_app_icon')}" {if $mobile_app_icon}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.mobile_app_version'}</label>
							<div class="controls">
								<input type="text" name="mobile_app_version" value="{$mobile_app_version}">
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.mobile_app_description'}</label>
							<div class="controls">
								<textarea class="span12 h100" name='mobile_app_description'>{$mobile_app_description}</textarea>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.mobile_app_video'}</label>
							<div class="controls">
								<input type="text" name="mobile_app_video" value="{$mobile_app_video}" />
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.label_bonus_readme'}</label>
							<div class="controls">
								<select name='bonus_readme' class="artilce_list">
									<!-- {if !$bonus_readme.title} -->
										<option value='-1'>{lang key='mobile::mobile.pls_select'}</option>
									<!-- {else} -->
										<option value="{$bonus_readme.id}">{$bonus_readme.title}</option>
									<!-- {/if} -->
								</select>
								<input type='text' name='article_search' class='m_l5 keywords'/>
								<input type='button' class='btn article_search' value="{lang key='mobile::mobile.search'}" data-url="{url path='mobile/admin_config/search_article'}"/>
								<span class="help-block">{lang key='mobile::mobile.search_notice'}</span>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.mobile_feedback_autoreply'}</label>
							<div class="controls">
								<input type='text' name='mobile_feedback_autoreply' value='{$mobile_feedback_autoreply}'>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.shop_pc_url'}</label>
							<div class="controls">
								<input type='text' name='shop_pc_url' value='{$shop_pc_url}'>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}邀请说明：{/t}</label>
							<div class="controls">
								<textarea class="span12 h100" name="recommend_notice" cols="40" rows="3">{$recommend_notice}</textarea>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}分享说明：{/t}</label>
							<div class="controls">
								<textarea class="span12 h100" name="share_notice" cols="40" rows="3">{$share_notice}</textarea>
							</div>
						</div>
					</div>

					{if 0}
					<div class="tab-pane" id="touch">
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.is_open_config'}</label>
							<div class="controls">
								<div id="info-toggle-button">
					                <input class="nouniform" name="wap_config" type="checkbox"  {if $wap_config eq 1}checked="checked"{/if}  value="1"/>
					            </div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.wap_Logo'}</label>
							<div class="controls">
								<div class="fileupload {if $wap_logo}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$wap_logo}" alt="{lang key='mobile::mobile.no_image'}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
									<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
									<input type="file" name="wap_logo"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=wap_logo')}" {if $mobile_pad_login_bgimage}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.shop_touch_url'}</label>
							<div class="controls">
								<input type='text' name='shop_touch_url' value='{$shop_touch_url}'>
							</div>
						</div>
					</div>
					{/if}

					<div class="tab-pane" id="load_app">
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.iphone_qr_code'}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_iphone_qrcode}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_iphone_qrcode}" alt="{lang key='mobile::mobile.no_image'}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
									<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
									<input type="file" name="mobile_iphone_qrcode"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_iphone_qrcode')}" {if $mobile_iphone_qrcode}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.mobile_iphone_download'}</label>
							<div class="controls">
								<input type='text' name='mobile_iphone_download' value='{$mobile_iphone_download}'>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.android_qr_code'}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_android_qrcode}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_android_qrcode}" alt="{lang key='mobile::mobile.no_image'}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
									<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
									<input type="file" name="mobile_android_qrcode"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_android_qrcode')}" {if $mobile_android_qrcode}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.mobile_android_download'}</label>
							<div class="controls">
								<input type='text' name='mobile_android_download' value='{$mobile_android_download}'>
							</div>
						</div>

						<!--
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.ipad_qr_code'}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_ipad_qr_code}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_ipad_qr_code}" alt="{lang key='mobile::mobile.no_image'}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
									<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
									<input type="file" name="mobile_ipad_qr_code"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_ipad_qr_code')}" {if $mobile_ipad_qr_code}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.shop_ipad_download'}</label>
							<div class="controls">
								<input type='text' name='shop_ipad_download' value='{$shop_ipad_download}'>
							</div>
						</div>
						 -->

						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.shopkeeper_urlscheme'}</label>
							<div class="controls">
								<input type='text' name='mobile_shopkeeper_urlscheme' value='{$mobile_shopkeeper_urlscheme}'>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.shop_urlscheme'}</label>
							<div class="controls">
								<input type='text' name='mobile_shop_urlscheme' value='{$mobile_shop_urlscheme}'>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="adsense">
						<div class="control-group formSep edit-page">
							<label class="control-label">{lang key='mobile::mobile.mobile_launch_adsense'}</label>
							<div class="controls">
								<select name='mobile_launch_adsense'>
									<option value='0'>{lang key='mobile::mobile.pls_select'}</option>
									<!-- {foreach from=$ad_position_list item=list} -->
										<option value="{$list.position_id}" {if $list.position_id eq $mobile_launch_adsense}selected{/if}>{$list.position_name}</option>
									<!-- {/foreach} -->
								</select>
								<span class="help-block">{lang key='mobile::mobile.launch_adsense_notice'}</span>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.launch_adsense_group'}</label>
							<div class="controls control-group draggable">
								<div class="ms-container span6" id="ms-custom-navigation">
									<div class="ms-selectable">
										<div class="search-header">
											<input class="span12" id="ms-search" type="text" placeholder="{lang key='mobile::mobile.filter_app_name'}" autocomplete="off">
										</div>
										<ul class="ms-list nav-list-ready select_adsense_group">
											<!-- {foreach from=$ad_position_list item=list} -->
											<li data-id="{$list.position_id}" id="position_id_{$list.position_id}" class="ms-elem-selectable isShow"><span>{$list.position_name}</span></li>
											<!-- {foreachelse}-->
											<li class="ms-elem-selectable disabled"><span>{lang key='mobile::mobile.no_content'}</span></li>
											<!-- {/foreach} -->
										</ul>
									</div>
									<div class="ms-selection">
										<div class="custom-header custom-header-align">{lang key='mobile::mobile.selected_ad_position'}</div>
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

						<!--
						<div class="control-group formSep edit-page">
							<label class="control-label">{lang key='mobile::mobile.launch_topic_set'}</label>
							<div class="controls">
								<select name='mobile_topic_adsense'>
									<option value='0'>{lang key='mobile::mobile.pls_select'}</option>
										{foreach from=$ad_position_list item=list}
										<option value="{$list.position_id}" {if $list.position_id eq $mobile_topic_adsense}selected{/if}>{$list.position_name}</option>
										{/foreach}
								</select>
								<span class="help-block">{lang key='mobile::mobile.topic_adsense_help'}</span>
							</div>
						</div>
						<div class="control-group formSep edit-page">
							<label class="control-label">{lang key='mobile::mobile.tv_big_ad_group'}</label>
							<div class="controls">
								<select name='mobile_tv_big_adsense'>
									<option value='0'>{lang key='mobile::mobile.pls_select'}</option>
										{foreach from=$ad_position_list item=list}
										<option value="{$list.position_id}" {if $list.position_id eq $mobile_tv_big_adsense}selected{/if}>{$list.position_name}</option>
										{/foreach}
								</select>
								<span class="help-block">{lang key='mobile::mobile.tv_ad_help'}</span>
							</div>
						</div>
						<div class="control-group formSep edit-page">
							<label class="control-label">{lang key='mobile::mobile.tv_small_ad_group'}</label>
							<div class="controls">
								<select name='mobile_tv_small_adsense'>
									<option value='0'>{lang key='mobile::mobile.pls_select'}</option>
										{foreach from=$ad_position_list item=list}
										<option value="{$list.position_id}" {if $list.position_id eq $mobile_tv_small_adsense}selected{/if}>{$list.position_name}</option>
										{/foreach}
								</select>
								<span class="help-block">{lang key='mobile::mobile.tv_ad_help'}</span>
							</div>
						</div>
						 -->
					</div>

					<div class="tab-pane" id="mobile_login">
						<h3 class="heading">{lang key='mobile::mobile.mobile_login_set'}</h3>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.mobile_login_fgcolor'}</label>
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
							<label class="control-label">{lang key='mobile::mobile.mobile_login_bgcolor'}</label>
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
							<label class="control-label">{lang key='mobile::mobile.mobile_login_bgimage'}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_phone_login_bgimage}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_phone_login_bgimage}" alt="{lang key='mobile::mobile.no_image'}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
									<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
									<input type="file" name="mobile_phone_login_bgimage"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_phone_login_bgimage')}" {if $mobile_phone_login_bgimage}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
								</div>
							</div>
						</div>

						<!--
						<h3 class="heading">{lang key='mobile::mobile.pad_login_set'}</h3>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.pad_login_fgcolor'}</label>
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
							<label class="control-label">{lang key='mobile::mobile.pad_login_bgcolor'}</label>
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
							<label class="control-label">{lang key='mobile::mobile.pad_login_bgimage'}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_pad_login_bgimage}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_pad_login_bgimage}" alt="{lang key='mobile::mobile.no_image'}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
									<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
									<input type="file" name="mobile_pad_login_bgimage"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_pad_login_bgimage')}" {if $mobile_pad_login_bgimage}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
								</div>
							</div>
						</div>
						-->

					</div>

					{if 0}
					<div class="tab-pane" id="tv_adsense">
						<div class="control-group formSep edit-page">
							<label class="control-label">TV首页广告位</label>
							<div class="controls">
								<select name='mobile_tv_home_adsense'>
									<option value='0'>{lang key='mobile::mobile.pls_select'}</option>
									<!-- {foreach from=$ad_position_list item=list} -->
										<option value="{$list.position_id}" {if $list.position_id eq $mobile_tv_home_adsense}selected{/if}>{$list.position_name}</option>
									<!-- {/foreach} -->
								</select>
								<span class="help-block">{lang key='mobile::mobile.launch_adsense_notice'}</span>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">TV首页广告组</label>
							<div class="controls control-group draggable">
								<div class="ms-container span6" id="ms-custom-navigation">
									<div class="ms-selectable">
										<div class="search-header">
											<input class="span12" id="ms-search" type="text" placeholder="{lang key='mobile::mobile.filter_adsense_name'}" autocomplete="off">
										</div>
										<ul class="ms-list tv-nav-list-ready select_tv_adsense_group">
											<!-- {foreach from=$ad_position_list item=list} -->
											<li data-id="{$list.position_id}" id="position_id_{$list.position_id}" class="ms-elem-selectable isShow"><span>{$list.position_name}</span></li>
											<!-- {foreachelse}-->
											<li class="ms-elem-selectable disabled"><span>{lang key='mobile::mobile.no_content'}</span></li>
											<!-- {/foreach} -->
										</ul>
									</div>
									<div class="ms-selection">
										<div class="custom-header custom-header-align">{lang key='mobile::mobile.selected_ad_position'}</div>
										<ul class="ms-list nav-list-ready tv-nav-list-content">
											<!-- {foreach from=$mobile_tv_home_adsense_group item=item key=key} -->
											<li class="tv-ms-elem-selection ms-elem-selection">
												<input type="hidden" value="{$item.position_id}" name="mobile_tv_home_adsense_group[]" />
												<!-- {$item.position_name} -->
												<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span>
											</li>
											<!-- {/foreach} -->
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					{/if}

					<div class="tab-pane" id="mobile_login">
						<h3 class="heading">{lang key='mobile::mobile.mobile_login_set'}</h3>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.mobile_login_fgcolor'}</label>
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
							<label class="control-label">{lang key='mobile::mobile.mobile_login_bgcolor'}</label>
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
							<label class="control-label">{lang key='mobile::mobile.mobile_login_bgimage'}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_phone_login_bgimage}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_phone_login_bgimage}" alt="{lang key='mobile::mobile.no_image'}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
									<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
									<input type="file" name="mobile_phone_login_bgimage"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_phone_login_bgimage')}" {if $mobile_phone_login_bgimage}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
								</div>
							</div>
						</div>
						<h3 class="heading">{lang key='mobile::mobile.pad_login_set'}</h3>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.pad_login_fgcolor'}</label>
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
							<label class="control-label">{lang key='mobile::mobile.pad_login_bgcolor'}</label>
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
							<label class="control-label">{lang key='mobile::mobile.pad_login_bgimage'}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_pad_login_bgimage}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_pad_login_bgimage}" alt="{lang key='mobile::mobile.no_image'}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
									<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
									<input type="file" name="mobile_pad_login_bgimage"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_pad_login_bgimage')}" {if $mobile_pad_login_bgimage}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="hot_city">
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.selected_area'}</label>
							<div class="controls selected_area chk_radio">
								<!-- {foreach from=$mobile_recommend_city item=region key=id} -->
								<input class="uni_style" type="checkbox" name="regions[]" value="{$id}" checked="checked" /> <span class="m_r10">{$region}&nbsp;&nbsp;</span>
								<!-- {/foreach} -->
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.hot_city'}</label>
							<div class="controls">
								<div class="ms-container ms-shipping span12" id="ms-custom-navigation">
									<div class="ms-selectable ms-mobile-selectable span2">
										<div class="search-header">
											<input class="span12" type="text" placeholder="{lang key='mobile::mobile.search_country_name'}" autocomplete="off" id="selCountry" />
										</div>
										<ul class="ms-list ms-list-mobile nav-list-ready selCountry" data-url="{url path='shipping/region/init' args='target=selProvinces&type=1'}" data-next="selProvinces">
											<!-- {foreach from=$countries item=country key=key} -->
											<li class="ms-elem-selectable select_hot_city" data-val="{$country.region_id}"><span>{$country.region_name|escape:html}</span></li>
											<!-- {foreachelse} -->
											<li class="ms-elem-selectable select_hot_city" data-val="0"><span>{lang key='mobile::mobile.empty_country'}</span></li>
											<!-- {/foreach} -->
										</ul>
									</div>
									<div class="ms-selectable ms-mobile-selectable span2">
										<div class="search-header">
											<input class="span12" type="text" placeholder="{lang key='mobile::mobile.search_province_name'}" autocomplete="off" id="selProvinces" />
										</div>
										<ul class="ms-list ms-list-mobile nav-list-ready selProvinces" data-url="{url path='shipping/region/init' args='target=selCities&type=2'}" data-next="selCities">
											<li class="ms-elem-selectable select_hot_city" data-val="0"><span>{lang key='mobile::mobile.select_province_first'}</span></li>
										</ul>
									</div>
									<div class="ms-selectable ms-mobile-selectable span2">
										<div class="search-header">
											<input class="span12" type="text" placeholder="{lang key='mobile::mobile.search_city_name'}" autocomplete="off" id="selCities" />
										</div>
										<ul class="ms-list ms-list-mobile nav-list-ready selCities">
											<li class="ms-elem-selectable select_hot_city" data-val="0"><span>{lang key='mobile::mobile.select_city_first'}</span></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane edit-page" id="message_notice">
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.remind_seller_ship'}</label>
							<div class="controls chk_radio">
								<input type='radio' name='order_reminder_type' value='2' {if $order_reminder_type eq 2}checked='checked'{/if} />{lang key='mobile::mobile.message_notice'}
								<input type='radio' name='order_reminder_type' value='1' {if $order_reminder_type eq 1}checked='checked'{/if} />{lang key='mobile::mobile.push_notice'}
								<input type='radio' name='order_reminder_type' value='0' {if $order_reminder_type eq 0}checked='checked'{/if} />{lang key='mobile::mobile.not_notice'}
							</div>
						</div>

						<div class="control-group formSep order_reminder_2 {if $order_reminder_type eq '0' || $order_reminder_type eq '1'}ecjiaf-dn{/if}">
							<label class="control-label order_reminder_2">{lang key='mobile::mobile.order_remind_by_message'}</label>
							<div class="controls chk_radio order_reminder_2">
								<input type='text' name='order_reminder_mobile' value='{$order_reminder_value}'>
							</div>
						</div>
						<div class="control-group formSep order_reminder_1 {if $order_reminder_type eq '0' || $order_reminder_type eq '2'}ecjiaf-dn{/if}">
							<label class="control-label">{lang key='mobile::mobile.order_remind_by_push'}</label>
							<div class="controls chk_radio">
								<select name='order_reminder_push'>
									<option value='0'>{lang key='mobile::mobile.pls_select'}</option>
									<!-- {foreach from=$admin_user_list item=list} -->
										<option value="{$list.user_id}" {if $list.user_id eq $order_reminder_value}selected{/if}>{$list.user_name}</option>
									<!-- {/foreach} -->
								</select>
							</div>
						</div>
					</div>

					<div class="tab-pane edit-page" id="app_screenshots">
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.mobile_app_name'}</label>
							<div class="controls l_h30">
								<span class="span6">{$mobile_app_name}</span>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.mobile_app_preview1'}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_app_preview1}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_app_preview1}" alt="{lang key='mobile::mobile.no_image'}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
									<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
									<input type="file" name="mobile_app_preview1"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_pad_login_bgimage')}" {if $mobile_pad_login_bgimage}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.mobile_app_preview2'}</label>
							<div class="controls">
								<div class="fileupload {if $mobile_app_preview2}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$mobile_app_preview2}" alt="{lang key='mobile::mobile.no_image'}" />
									</div>
									<span class="btn btn-file">
										<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
										<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
										<input type="file" name="mobile_app_preview2"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_pad_login_bgimage')}" {if $mobile_pad_login_bgimage}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
								</div>
							</div>
						</div>
					    <div class="control-group formSep">
							<!-- <label class="control-label">{lang key='mobile::mobile.mobile_app_screenshots'}</label> -->

                            <div class="row-fluid mobile-fileupload" data-action="{url path='mobile/admin_config/insert'}" data-remove="{url path='mobile/admin_config/drop_image'}"></div>
                            <div class="row-fluid {if !$img_list} hide{/if}" style="margin-top:30px;">
                            	<div class="span12">
                            		<h3 class="heading m_b10">{lang key='mobile::mobile.mobile_app_screenshots'}<small>{lang key='goods::goods.goods_photo_notice'}</small></h3>
                            		<div class="m_b20"><span class="help-inline">{lang key='goods::goods.goods_photo_help'}</span></div>
                            		<div class="wmk_grid ecj-wookmark wookmark_list">
                            			<ul class="wookmark-goods-photo move-mod nomove">
                            				<!-- {foreach from=$img_list item=img} -->
                            				<li class="thumbnail move-mod-group">
                            					<div class="attachment-preview">
                            						<div class="ecj-thumbnail">
                            							<div class="centered">
                            								<a class="bd" title="{$img.img_desc}">
                            									<img data-original="{$img.sort}" src="{$img.img_url}" alt="" />
                            								</a>
                            							</div>
                            						</div>
                            					</div>
                            					<p>
                            						<a href="javascript:;" title="{lang key='goods::goods.cancel'}" data-toggle="sort-cancel" style="display:none;"><i class="fontello-icon-cancel"></i></a>
                            						<a href="javascript:;" title="{lang key='goods::goods.save'}" data-toggle="sort-ok" data-imgid="{$img.id}" data-saveurl="{url path='mobile/admin_config/update_image_desc'}" style="display:none;"><i class="fontello-icon-ok"></i></a>
                            						<a class="ajaxremove" data-imgid="{$img.id}" data-toggle="ajaxremove" data-msg="{lang key='mobile::mobile.drop_screenshots_confirm'}" href='{url path="mobile/admin_config/drop_image" args="id={$img.id}"}' title="{lang key='system::system.remove'}"><i class="icon-trash"></i></a>
                            						<a class="move-mod-head" href="javascript:void(0)" title="{lang key='goods::goods.move'}"><i class="icon-move"></i></a>
                            						<a href="javascript:;" title="{lang key='system::system.edit'}" data-toggle="edit"><i class="icon-pencil"></i></a>
                            						<span class="edit_title">{if $img.img_desc}{$img.img_desc}{else}{lang key='goods::goods.no_title'}{/if}</span>
                            					</p>
                            				</li>
                            				<!-- {/foreach} -->
                            			</ul>
                            		</div>
                            	</div>
                            	<a class="btn btn-info save-sort" data-sorturl="{url path='mobile/admin_config/sort_image'}">{lang key='goods::goods.save_sort'}</a>
                            </div>
						</div>
					</div>

					<!--
					<div class="tab-pane" id="integral_manage">
						<h3 class="heading">{lang key='mobile::mobile.sign_points'}</h3>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.is_open_sign_points'}</label>
							<div class="controls">
								<div id="is_open_checkin">
					                <input class="nouniform" name="checkin_award_open" type="checkbox"  {if $checkin_award_open eq 1}checked="checked"{/if}  value="1"/>
					            </div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.checkin_award_type'}</label>
							<div class="controls">
								<select name='checkin_award_type'>
									<option value="integral">{lang key='mobile::mobile.integral'}</option>
								</select>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.checkin_award'}</label>
							<div class="controls">
								<input type='text' name='checkin_award' value='{$checkin_award}'>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.checkin_extra_day'}</label>
							<div class="controls">
								<input type='text' name='checkin_extra_day' value='{$checkin_extra_day}'>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.checkin_extra_award'}</label>
							<div class="controls">
								<input type='text' name='checkin_extra_award' value='{$checkin_extra_award}'>
							</div>
						</div>
						<h3 class="heading">{lang key='mobile::mobile.comment_integral'}</h3>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.comment_award_open'}</label>
							<div class="controls">
								<div id="is_open_comment_integral">
					                <input class="nouniform" name="comment_award_open" type="checkbox"  {if $comment_award_open eq 1}checked="checked"{/if}  value="1"/>
					            </div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.comment_once_award'}</label>
							<div class="controls">
								<input type='text' name='comment_award' value='{$comment_award}'>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><strong>{lang key='mobile::mobile.user_rank'}</strong></label>
							<label class="control-label">
								<strong>{lang key='mobile::mobile.comment_get_award'}</strong>
							</label>
						</div>
						{foreach from=$user_rank_list item=item}
						<div class="control-group">
							<label class="control-label">{t}{$item.rank_name}：{/t}</label>
							<div class="controls">
								<input type='text' name="comment_award_rules[{$item.rank_id}]" value="{$item.comment_award}">
							</div>
						</div>
						{/foreach}
						<div class="control-group">
							<div class="controls">
								<span class="help-block">{lang key='mobile::mobile.comment_award_rules'}</span>
							</div>
						</div>
					</div>
					-->

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
