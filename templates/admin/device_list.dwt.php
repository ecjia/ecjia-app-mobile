<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.device_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
	<div>
		<h3 class="heading">
			<!-- {if $ur_here}{$ur_here}{/if} -->
			{if $action_link}
			<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
			{/if}
		</h3>
	</div>

	<!-- <div class="row-fluid"> -->
		<!-- <div class="choose_list span12">  -->
		<ul class="nav nav-pills">
			<li class="{if $device_list.filter.deviceval eq '0'}active{/if}"><a class="data-pjax" href='{url path="mobile/admin_device/init" args="deviceval=0"}'>全部 <span class="badge badge-info">{$device_list.msg_count.count}</span></a></li>
			<li class="{if $device_list.filter.deviceval eq '1'}active{/if}"><a class="data-pjax" href='{url path="mobile/admin_device/init" args="deviceval=1"}'>Android<span class="badge badge-info">{$device_list.msg_count.android}</span></a></li>
			<li class="{if $device_list.filter.deviceval eq '2'}active{/if}"><a class="data-pjax" href='{url path="mobile/admin_device/init" args="deviceval=2"}'>iPhone<span class="badge badge-info">{$device_list.msg_count.iphone}</span></a></li>
			<li class="{if $device_list.filter.deviceval eq '3'}active{/if}"><a class="data-pjax" href='{url path="mobile/admin_device/init" args="deviceval=3"}'>iPad<span class="badge badge-info">{$device_list.msg_count.ipad}</span></a></li>
			<li class="{if $device_list.filter.deviceval eq '4'}active{/if}"><a class="data-pjax" href='{url path="mobile/admin_device/init" args="deviceval=4"}'>回收站<span class="badge badge-info">{$device_list.msg_count.trashed}</span></a></li>
		</ul>
		<!-- </div> -->
	<!-- </div> -->

	<!-- 批量操作和搜索 -->
	<div class="row-fluid batch" >
		<form method="post" action="{$search_action}" name="searchForm">
			<div class="btn-group f_l m_r5">
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fontello-icon-cog"></i>{t}批量操作{/t}
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<!-- {if $device_list.filter.deviceval eq '4'} -->
					<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="mobile/admin_device/batch" args="&sel_action=returndevice&deviceval={$device_list.filter.deviceval}"}' data-msg="您确定要这么做吗？" data-noSelectMsg="请先选中要还原的设备！" data-name="id" href="javascript:;"><i class="fontello-icon-reply-all"></i>{t}还原设备{/t}</a></li>
					<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="mobile/admin_device/batch" args="&sel_action=del&deviceval={$device_list.filter.deviceval}"}'  data-msg="您确定要这么做吗？" data-noSelectMsg="请先选中要永久删除的设备！" data-name="id" href="javascript:;"><i class="fontello-icon-trash"></i>{t}永久删除{/t}</a></li>
					<!-- {else} -->
					<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="mobile/admin_device/batch" args="&sel_action=trash&deviceval={$device_list.filter.deviceval}"}'  data-msg="您确定要这么做吗？" data-noSelectMsg="请先选中要移至回收站的设备！" data-name="id" href="javascript:;"><i class="fontello-icon-box"></i>{t}移至回收站{/t}</a></li>
					<!-- {/if} -->
				</ul>
			</div>
			<div class="choose_list f_r" >
				<input type="text" name="keywords" value="{$device_list.filter.keywords}" placeholder="请输入设备名称"/>
				<button class="btn search_device" type="button">搜索</button>
			</div>
		</form>
	</div>

	<div class="row-fluid list-page">
		<div class="span12">	
			<form method="POST" action="{$form_action}" name="listForm">
				<div class="row-fluid">	
					<table class="table table-striped smpl_tbl table-hide-edit">
						<thead>
							<tr>
								<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
								<th class="w200">{t}设备类型{/t}</th>
								<th class="w300">{t}设备名称{/t}</th>
								<th class="w200">{t}操作系统{/t}</th>
								<th class="w200">{t}位置{/t}</th>
								<th class="w200">{t}添加时间{/t}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$device_list.device_list item=val} -->
								<tr>
									<td>
										<span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.id}"/></span>
									</td>
									<td class="hide-edit-area">
									{$val.device_client}
							    	<div class="edit-list">
								     	{if $device_list.filter.deviceval eq '4'}
     										<a class="toggle_view" data-msg="{t}您确定要将此设备还原吗？{/t}" href='{url path="mobile/admin_device/returndevice" args="id={$val.id}"}' data-pjax-url='{url path="mobile/admin_device/init" args="deviceval={$device_list.filter.deviceval}"}' data-val="back">还原</a>&nbsp;|&nbsp;
								     		<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t}您确定要删除设备[{$val.device_name}]吗？{/t}" href='{RC_Uri::url("mobile/admin_device/remove","id={$val.id}&deviceval={$device_list.filter.deviceval}")}'>{t}永久删除{/t}</a>
								     	{else}
									     	{assign var=view_url value=RC_Uri::url('mobile/admin_device/preview',"id={$val.id}")}
									      	<a class="data-pjax" href="{$view_url}" title="{$lang.view}">{t}查看{/t}</a>&nbsp;|&nbsp;
									     	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t}您确定要删除设备[{$val.device_name}]至回收站吗？{/t}" href='{RC_Uri::url("mobile/admin_device/trash","id={$val.id}&deviceval={$device_list.filter.deviceval}")}' title="{t}移除{/t}">{t}移至回收站{/t}</a>
								     	{/if}
								     	
								     	
								     </div>
									</td>
									<td>
									{if $val.device_name && $val.device_udid}
									{$val.device_name}<br>{$val.device_udid}
									{elseif $val.device_name}
									{$val.device_name}
									{elseif $val.device_udid}
									{$val.device_udid}
									{/if}
									</td>
									<td>{$val.device_os}</td>
									<td>{$val.location_province}</td>
									<td>{$val.add_time}</td>
								</tr>
								<!--  {foreachelse} -->
							<tr><td class="no-records" colspan="10">{$lang.no_records}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div> 
	<!-- {$device_list.page} -->
<!-- {/block} -->