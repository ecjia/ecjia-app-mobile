<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.mobile_config.info();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active"><a href='javascript:;'>推送配置</a></li>
			<li><a class="data-pjax" href='{url path="mobile/admin_mobile_config/config_pay" args="code={$code}&id={$id}"}'>支付配置</a></li>
		</ul>
		
		<div class="tab-content">
			<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post"  >
				<fieldset>
					<div class="control-group formSep">
						<label class="control-label">Api Key：</label>
						<div class="controls">
							<input class="span4" name="api_key" type="text" value="" />
							<span class="input-must">{lang key='system::system.require_field'}</span> 
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">Secret Key：</label>
						<div class="controls">
							<input class="span4" name="secret_key" type="text" value="" />
							<span class="input-must">{lang key='system::system.require_field'}</span> 
						</div>
					</div>
					
					<div class="control-group">
						<div class="controls">
						<input type="hidden" name="id"   value="{$id}">
						<input type="hidden" name="code" value="{$code}">
							<button class="btn btn-gebo" type="submit">确定</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
	</div>
</div>
<!-- {/block} -->