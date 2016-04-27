<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.toutiao.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>	
</div>	
<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" action="{$form_action}" method="post" name="theForm" enctype="multipart/form-data">
			<fieldset>
				<div class="control-group formSep" >
					<label class="control-label">{lang key='mobile::mobile.label_headline_title'}</label>
					<div class="controls">
						<input type="text" name="title" class="w300" value="{$data.title}" />
						<span class="input-must">*</span>
					</div>
				</div>
				<div class="control-group formSep" >
					<label class="control-label">{lang key='mobile::mobile.label_tag'}</label>
					<div class="controls">
						<input type="text" name="tag" class="w300" value="{$data.tag}" />
					</div>
				</div>
				<div class="control-group formSep" >
					<label class="control-label">{lang key='mobile::mobile.label_headline_content'}</label>
					<div class="controls">
						<textarea name="description" cols="50" rows="6" class="w300">{$data.description}</textarea>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='mobile::mobile.label_headline_img'}</label>
					<div class="controls">
						<div class="fileupload {if $data.image}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
							<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
								<img src="{$data.image}"/>
							</div>
							<span class="btn btn-file">
							<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
							<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
							<input type="file" name="image"/>
							</span>
							<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_image_confirm'}" data-href="{RC_Uri::url('mobile/admin_mobile_toutiao/remove_image',"id={$data.id}")}" {if $data.image}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
							<span class="input-must">{lang key='system::system.require_field'}</span> 
						</div>
					</div>
				</div>
				<div class="control-group formSep" >
					<label class="control-label">{lang key='mobile::mobile.label_headline_url'}</label>
					<div class="controls">
						<input type="text" name="content_url" class="w300" value="{if $data.content_url}{$data.content_url}{else}http://{/if}" />
					</div>
				</div>
				<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.label_is_open'}</label>
						<div class="controls">
							<div id="info-toggle-button">
				                <input class="nouniform" name="status" type="checkbox"  {if $data.status eq 1}checked="checked"{/if}  value="1"/>
				            </div>
						</div>
					</div>
				<div class="control-group formSep" >
					<label class="control-label">{lang key='mobile::mobile.label_sort'}</label>
					<div class="controls">
						<input type="text" name="sort_order" class="w300" value="{if $data.sort_order}{$data.sort_order}{else}100{/if}" />
					</div>
				</div>
				<!-- {if $data.id} -->
				<div class="control-group formSep" >
					<label class="control-label">{lang key='mobile::mobile.label_create_time'}</label>
					<div class="controls l_h30">
						<span>{$data.create_time}</span>
					</div>
				</div>
				<!-- {/if} -->
				
				<div class="control-group">
					<div class="controls">
						<input type="submit" name="submit" value="{if $data.id}{lang key='mobile::mobile.update'}{else}{lang key='system::system.button_submit'}{/if}" class="btn btn-gebo" />	
						<input type="hidden" name="id" value="{$data.id}" />
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->