<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->

<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"  id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid list-page">
	<div class="span12">
		<div class="tab-content">
			<!-- system start -->
			<div class="tab-pane active">
				<table class="table table-striped table-hide-edit" data-rowlink="a">
					<thead>
						<tr>
							<th class="w50">{t}应用ID{/t}</th>
							<th>{t}应用名称{/t}</th>
							<th>{t}应用包名{/t}</th>
							<th>{t}客户端{/t}</th>
							<th>{t}服务平台{/t}</th>
							<th>{t}排序{/t}</th>
							<th class="w100">{t}创建时间{/t}</th>
						</tr>
					</thead>
					<!-- {foreach from=$mobile_manage item=item key=key name=children} -->
					<tr>
						<td c>
							{$item.app_id}
						</td>
						<td class="hide-edit-area">
							{$item.app_name}
							<div class="edit-list">
								<a class="data-pjax" href="{RC_Uri::url('mobile/admin_mobile_manage/edit',"id={$item.app_id}")}" title="{t}编辑{/t}">{t}编辑{/t}</a>&nbsp;|&nbsp;
								<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg="{t}您确定要删除该移动应用吗？{/t}" href="{RC_Uri::url('mobile/admin_mobile_manage/remove',"id={$item.app_id}")}" title="{t}移除{/t}">{t}删除{/t}</a>
						    </div>
						</td>
						<td>
							{$item.bundle_id}
						</td>
						<td>
							{$item.device_client}
						</td>
						<td>
							<!-- {if $item.platform eq 'umeng-push'} -->
							{t}友盟推送{/t}
							<!-- {/if} -->
						</td>
						<td>
							<span class="edit_sort cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('mobile/admin_mobile_manage/edit_sort',"id={$item.app_id}")}" data-name="sort" data-pk="{$item.app_id}"  data-title="编辑客户端排序">{$item.sort}</span>
						</td>
						<td>
							{$item.add_time}
						</td>
					</tr>
					<!-- {foreachelse} -->
					   <tr><td class="no-records" colspan="7">{t}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</table>
			</div>
			<!-- system end -->
		</div>
	</div>
</div>
{$mobile_manage_page}
<!-- {/block} -->