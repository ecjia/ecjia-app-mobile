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
					<label class="control-label">应用名称：</label>
					<div class="controls">
						<input class="span4" name="name" type="text" value="{$manage_data.app_name}" />
						<span class="input-must">{lang key='system::system.require_field'}</span> 
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">应用包名：</label>
					<div class="controls">
						<input class="span4" name="bundleid" type="text" value="{$manage_data.bundle_id}" />
						<span class="input-must">{lang key='system::system.require_field'}</span> 
					</div>
				</div>
				
				{if $action eq 'edit'}
					<div class="control-group formSep">
						<label class="control-label">Code：</label>
						<div class="controls l_h30">
							{$manage_data.platform}
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">Client：</label>
						<div class="controls l_h30">
							{$manage_data.device_client}
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">Device Code：</label>
						<div class="controls l_h30">
							{$manage_data.device_code}
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">AppKey：</label>
						<div class="controls l_h30">
							{$manage_data.app_key}
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">AppSecret：</label>
						<div class="controls l_h30">
							{$manage_data.app_secret}
						</div>
					</div>
				{/if}
				
				<div class="control-group formSep">
					<label class="control-label">是否启用</label>
					<div class="controls">
			            <div id="info-toggle-button">
			                <input class="nouniform" name="status" type="checkbox"  {if $manage_data.status eq 1}checked="checked"{/if}  value="1"/>
			            </div>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">排序</label>
					<div class="controls">
						<input name="sort" type="text" value="{if $manage_data.sort}{$manage_data.sort}{else}0{/if}" />
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="hidden" name="id" value="{$manage_data.app_id}" />
							
						<input type="hidden" name="device_code" value={$device_code} />
						<input type="hidden" name="device_client" value={$device_client} />
						<input type="hidden" name="code" value={$code} />
						
						{if $action eq 'edit'}
							<button class="btn btn-gebo" type="submit">更新</button>
							<a data-toggle="ajaxremove" class="ajaxremove"  data-msg="你确定要删除该客户端端吗？"  href='{RC_Uri::url("mobile/admin_mobile_manage/remove","id={$manage_data.app_id}&code={$manage_data.platform}")}' title="删除"><button class="btn btn-gebo" type="submit">删除</button></a>
						{else}
							<button class="btn btn-gebo" type="submit">激活</button>
						{/if}
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->