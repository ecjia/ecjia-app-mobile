<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->

<script type="text/javascript">
	ecjia.admin.mobile_manage.info();
</script>

<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t}应用名称：{/t}</label>
					<div class="controls">
						<input class="span4" name="name" type="text" value="{$mobile_manage.app_name}" />
						<span class="input-must"><span class="require-field">*</span></span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}应用包名：{/t}</label>
					<div class="controls">
						<input class="span4" name="bundleid" type="text" value="{$mobile_manage.bundle_id}" />
						<span class="input-must"><span class="require-field">*</span></span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}Client：{/t}</label>
					<div class="controls">
						<select name='client' class="span4">
							<option value=''>{t}请选择{/t}</option>
							<!-- {foreach from=$mobile_client item=item key=key} -->
							<option value='{$key}' {if $mobile_manage.device_client eq $key}selected='selected'{/if}>{$item}</option>
							<!-- {/foreach} -->
						</select>
						<span class="input-must"><span class="require-field">*</span></span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}Code：{/t}</label>
					<div class="controls">
						<!-- {if $mobile_manage.device_code} -->
							<div class="p_t5">
							{$mobile_manage.device_code}</div>
						<!-- {else} -->
							<input class="span4" name="code" type="text" value="" />
							<span class="input-must"><span class="require-field">*</span></span>
						<!-- {/if} -->
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}AppKey：{/t}</label>
					<div class="controls">
						<input class="span4" name="appkey" type="text" value="{$mobile_manage.app_key}" />
						<span class="input-must"><span class="require-field">*</span></span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}AppSecret：{/t}</label>
					<div class="controls">
						<input class="span4" name="appsecret" type="text" value="{$mobile_manage.app_secret}" />
						<span class="input-must"><span class="require-field">*</span></span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}服务平台：{/t}</label>
					<div class="controls">
						<select name='platform' class="span4">
							<option value=''>{t}请选择{/t}</option>
							<option value="umeng-push" {if $mobile_manage.platform eq 'umeng-push'}selected='selected'{/if}>{t}友盟推送{/t}</option>
						</select>
						<span class="input-must"><span class="require-field">*</span></span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}是否启用：{/t}</label>
					<div class="controls">
			            <div id="info-toggle-button">
			                <input class="nouniform" name="status" type="checkbox"  {if $mobile_manage.status eq 1}checked="checked"{/if}  value="1"/>
			            </div>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}排序：{/t}</label>
					<div class="controls">
						<input name="sort" type="text" value="{if $mobile_manage.sort}{$mobile_manage.sort}{else}0{/if}" />
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="hidden"  name="id"		value="{$mobile_manage.app_id}" />
						{if $rt.id eq ''}
						<button class="btn btn-gebo" type="submit">{t}确定{/t}</button>
						{else}
						<button class="btn btn-gebo" type="submit">{t}更新{/t}</button>
						{/if}
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->