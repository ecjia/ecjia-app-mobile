<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"  id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
	</h3>
</div>

<div class="row-fluid ">
	<div class="span12">
		<div class="container_list">
			<ul>
				<!-- {foreach from=$manage_list.item item=list} -->
					<li>
						<p style="text-align: right;">
						{if $list.status eq 1}
							<img src="{$ok_img}" />
						{else}
							<img src="{$error_img}" />
						{/if}
						</p>
						<h2>{$list.app_name}</h2>
						<h3></h3>
						<p style="margin-top:25px;"> Platform：{$list.platform}<br/> Bundle Id:{$list.app_key}<br/></p>
						<p style="margin-top:30px;">
							{if $list.device_client eq 'Android'}
						 		<img src="{$Android_img}" />
						 	{else}
						 		<img src="{$iPhone_img}" />
						 	{/if}
						</p>
						<p style="margin-top:60px;">
							<a><span>编辑</span></a>
							<a style="margin-left:10px;"><span >删除</span></a>
						</p>
					</li>
				<!-- {/foreach} -->
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->