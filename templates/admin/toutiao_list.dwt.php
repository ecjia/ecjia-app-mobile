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
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" ><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid batch" >
	<div class="btn-group f_l m_r5">
		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fontello-icon-cog"></i>{lang key='mobile::mobile.batch_handle'}
			<span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			<li><a data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}" data-msg="{lang key='mobile::mobile.batch_drop_confirm'}" data-noSelectMsg="{lang key='mobile::mobile.pls_select_option'}" data-name="checkboxes" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='system::system.drop'}</a></li>
		</ul>
	</div>
	
	<div class="choose_list f_r">
		<form method="post" action="{$search_action}{if $smarty.get.status}&status={$smarty.get.status}{/if}" name="searchForm">
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='mobile::mobile.headline_keywords_empty'}" /> 
			<input type="submit" value="{lang key='mobile::mobile.search'}" class="btn"/>
		</form>
	</div>	
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
					<th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox" /></th>
					<th class='w150'>{lang key='mobile::mobile.image'}</th>
					<th class='w150'>{lang key='mobile::mobile.headline_title'}</th>
					<th class='w100'>{lang key='mobile::mobile.tag'}</th>
					<th>{lang key='mobile::mobile.headline_content'}</th>
					<th class='w100'>{lang key='mobile::mobile.headline_url'}</th>
					<th class='w130'>{lang key='mobile::mobile.create_time'}</th>
				</tr>
			</thead>
			<tbody>
				<!--{foreach from=$lists.item item=list}-->
				<tr>
					<td class="center-td">
						<input class="checkbox" type="checkbox" name="checkboxes[]"  value="{$list.id}" />
					</td>
					<td><img class="w150 h70" alt="{$list.image}" src="{$list.image}"></td>
					<td class="hide-edit-area">
						<span>{$list.title}</span>
						<br/>
						<div class="edit-list">
							<a class="data-pjax" href='{url path="mobile/admin_mobile_toutiao/edit" args="id={$list.id}"}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='mobile::mobile.drop_headline_confirm'}" href='{RC_Uri::url("mobile/admin_mobile_toutiao/remove","id={$list.id}")}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
						</div>
					</td>
					<td>{$list.tag}</td>
					<td>{$list.description}</td>
					<td><a href='{$list.content_url}' target='_blank'>{$list.content_url}</a></td>
					<td>{$list.create_time}</td>
				</tr>
				<!--{foreachelse}-->
				<tr><td class="no-records" colspan="7">{lang key='system::system.no_records'}</td></tr>
				<!--{/foreach} -->
			</tbody>
		</table>
		<!-- {$lists.page} -->
	</div>
</div>
<!-- {/block} -->