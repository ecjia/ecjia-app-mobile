<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.cycleimage.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link_special} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link_special.href}"  id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link_special.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid list-page">
	<div class="span12">
		<div class="">
			<div class="tab-content">
				<!-- system start -->
				<div class="tab-pane active">
					<table class="table table-striped table-hide-edit" data-rowlink="a">
						<thead>
							<tr>
								<th class="w180">{t}菜单图标{/t}</th>
								<th>{t}菜单链接{/t}</th>
								<th>{t}是否显示{/t}</th>
								<th class="w150">{t}菜单排序{/t}</th>
							</tr>
						</thead>
						<!-- {foreach from=$playerdb item=item key=key} -->
						<tr>
							<td>
								<a href="{$item.src}" title="Image 10" target="_blank">
									<img class="w80 h70" alt="{$item.src}" src="{$item.src}">
								</a>
							</td>
							<td class="hide-edit-area">
								<span><a href="{$item.url}" target="_blank">{$item.url}</a></span><br>
								{$item.text}
								<div class="edit-list">
									<a class="data-pjax" href="{RC_Uri::url('mobile/admin_shortcut/edit',"id={$key}")}" title="{t}编辑{/t}">{t}编辑{/t}</a>&nbsp;|&nbsp;
									<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg="{t}您确定要删除该菜单吗？{/t}" href="{RC_Uri::url('mobile/admin_shortcut/remove',"id={$key}")}" title="{t}移除{/t}">{t}删除{/t}</a>
							    </div>
							</td>
							<td>
						    	<i class="{if $item.display eq '1'}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('mobile/admin_shortcut/toggle_show')}" data-id="{$key}" ></i>
							</td>
							<td><span class="edit_sort cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('mobile/admin_shortcut/edit_sort',"id={$key}")}" data-name="sort" data-pk="{$key}"  data-title="编辑菜单排序">{$item.sort}</span></td>
						</tr>
						<!-- {foreachelse} -->
						   <tr><td class="no-records" colspan="10">{t}没有找到任何记录{/t}</td></tr>
						<!-- {/foreach} -->
					</table>
				</div>
				<!-- system end -->
			</div>
		</div>
	</div>
</div> 
<!-- {/block} -->