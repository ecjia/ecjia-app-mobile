<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
		{if $action_linkedit}
		<a class="btn plus_or_reply data-pjax" href="{$action_linkedit.href}" id="sticky_a" ><i class="fontello-icon-edit"></i>{$action_linkedit.text}</a>
		{/if}
	</h3>	
</div>


<div class="row-fluid goods_preview">
	<div class="span12 ">
		<div class="foldable-list move-mod-group" id="goods_info_sort_submit">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_submit">
						<strong>{t}移动设备信息{/t}</strong>
					</a>
				</div>
				<div class="accordion-body in collapse" id="goods_info_area_submit">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{t}用户ID：{/t}</strong></div></td>
								<td colspan="3">{if $device.user_id eq 0}暂无{else}{$device.user_id}{/if}&nbsp;&nbsp;&nbsp;{if $device.is_admin eq 0}【不是管理员】{else}【是管理员】{/if}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t}设备类型：{/t}</strong></div></td>
								<td>{$device.device_client}</td>
								<td><div align="right"><strong>{t}设备名称：{/t}</strong></div></td>
								<td>{$device.device_name}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t}操作系统：{/t}</strong></div></td>
								<td>{$device.device_os}</td>
								<td><div align="right"><strong>{t}UDID：{/t}</strong></div></td>
								<td>{$device.device_udid}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t}设备别名：{/t}</strong></div></td>
								<td>
							        <span class="cursor_pointer" data-text="text" data-trigger="editable" data-url="{RC_Uri::url('mobile/admin_device/edit_device_alias')}" data-name="device_alias" data-pk="{$device.id}" data-title="编辑设备别名" >{$device.device_alias}</span>
							    </td>
								<td><div align="right"><strong>{t}状态：{/t}</strong></div></td>
								<td>{if $device.in_status eq 0}有效{else}无效{/if}</td>
							</tr>	
							<tr>
								<td><div align="right"><strong>{t}添加时间：{/t}</strong></div></td>
								<td>{$device.add_time}</td>
								<td><div align="right"><strong>{t}位置：{/t}</strong></div></td>
								<td>{$device.location_province}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t}DeviceToken：{/t}</strong></div></td>
								<td colspan="3">{$device.device_token}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->













