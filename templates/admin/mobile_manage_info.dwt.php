<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="mobile_config_parent.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.mobile_manage.info();
</script>
<!-- {/block} -->
<!-- {block name="main_right_content"} -->

<!-- {ecjia:hook id=mobile_platform_client_menus} -->

<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
    <fieldset>
        <div class="control-group formSep">
            <label class="control-label">应用名称：</label>
            <div class="controls l_h30">
                <span class="cursor_pointer ecjiaf-pre ecjiaf-wsn" data-trigger="editable" data-url='{url path="mobile/admin_mobile_manage/edit_app_name" args="code={$manage_data.platform}"}' data-name="app_name" data-pk="{$manage_data.app_id}" data-title="应用名称">{$manage_data.app_name}</span>
            </div>
        </div>

        <div class="control-group formSep">
            <label class="control-label">应用包名：</label>
            <div class="controls l_h30">
                <span class="cursor_pointer ecjiaf-pre ecjiaf-wsn" data-trigger="editable" data-url='{url path="mobile/admin_mobile_manage/edit_bag_name" args="code={$manage_data.platform}"}' data-name="bag_name" data-pk="{$manage_data.app_id}" data-title="应用包名">{if $manage_data.bundle_id}{$manage_data.bundle_id}{else}{t domain="refund"}未设置{/t}{/if}</span>
            </div>
        </div>

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

        <div class="control-group">
            <label class="control-label">Device Code：</label>
            <div class="controls l_h30">
                {$manage_data.device_code}
            </div>
        </div>

        <h3 class="heading">安全信息</h3>
        <div class="control-group formSep">
            <label class="control-label">AppKey：</label>
            <div class="controls l_h30">
                <div id="app_key" class="app_copy" data-clipboard-text="{$manage_data.app_key}">
                    <span>{$manage_data.app_key}</span>
                    <span class="cursor_pointer copy"><strong>复制</strong></span>
                </div>
            </div>
        </div>

        <div class="control-group formSep">
            <label class="control-label">AppSecret：</label>
            <div class="controls l_h30">
                <div id="app_secret"class="app_copy" data-clipboard-text="{$manage_data.app_secret}">
                    <span>{$manage_data.app_secret}</span>
                    <span class="cursor_pointer copy">复制</span>
                </div>
            </div>
        </div>

        <input type="hidden" name="code_vale" value="{$manage_data.platform}" />
        <input type="hidden" name="id" value="{$manage_data.app_id}" />
        <a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red"  data-msg="你确定要删除该客户端端吗？"  href='{RC_Uri::url("mobile/admin_mobile_manage/remove","id={$manage_data.app_id}&code={$manage_data.platform}")}' title="删除">删除客户端</a>
        <div class="pull-right">
            <a class="change_status" style="cursor: pointer;"
               data-msg="{if $manage_data.status eq 1}您确定要关闭该客户端吗？{else}您确定要开启该客户端吗？{/if}"
               data-href='
						 {if $manage_data.status eq 1}
						 	{url path="mobile/admin_mobile_manage/close_status" args="code={$manage_data.platform}&id={$manage_data.app_id}"}
						 {else}
						 	{url path="mobile/admin_mobile_manage/open_status" args="code={$manage_data.platform}&id={$manage_data.app_id}"}
						 {/if}' >
                {if $manage_data.status eq 1}
                <button class="btn" type="button" >点击关闭客户端</button>
                {else}
                <button class="btn btn-gebo" type="button" >点击开启客户端</button>
                {/if}
            </a>
        </div>
    </fieldset>
</form>
<!-- {/block} -->