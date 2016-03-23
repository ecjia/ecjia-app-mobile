<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	
</script>
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
							<th class="w200">{t}今日热点主图{/t}</th>
							<th>{t}内容标题{/t}</th>
							<th class="w150">{t}创建时间{/t}</th>
						</tr>
					</thead>
					<!-- {foreach from=$mobile_news item=item key=key name=children} -->
					
					<tr>
						<td>
							<a href="{$item.image}" title="Image 10" target="_blank">
								<img class="w200 h100" alt="{$item.image}" src="{$item.image}">
							</a>
						</td>
						<td class="hide-edit-area">
							1、<span>{$item.title}</span><br>
							<!-- {foreach from=$item.children item=childitem key=k} -->
								{$k+2}、<span>{$childitem.title}</span><br>
							<!-- {/foreach} -->
							{$item.text}
							<div class="edit-list">
								<a class="data-pjax" href="{RC_Uri::url('mobile/admin_mobile_news/edit',"id={$item.id}")}" title="{t}编辑{/t}">{t}编辑{/t}</a>&nbsp;|&nbsp;
								<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg="{t}您确定要删除该今日热点吗？{/t}" href="{RC_Uri::url('mobile/admin_mobile_news/remove',"id={$item.id}")}" title="{t}移除{/t}">{t}删除{/t}</a>
						    </div>
						</td>
						<td>
					    	{$item.create_time}
						</td>
						
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
{$mobile_news_page}
<!-- {/block} -->