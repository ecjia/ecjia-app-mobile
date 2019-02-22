<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

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
    <div class="span3">

        <div class="setting-group m_b20">
            <span class="setting-group-title"><i class="fontello-icon-cog"></i>{t domain="mobile"}应用配置{/t}</span>
            <ul class="nav nav-list m_t10">
                <!-- {foreach from=$config_groups item=group} -->
                <li>
                    <a class="setting-group-item
                            {if $group.code == $current_group}
                            llv-active
                            {/if}
                            " href="{$group.link}">{$group.name}</a>
                </li>
                <!-- {/foreach} -->
            </ul>
        </div>

    </div>

    <div class="span9">
    <!-- {block name="main_right_content"} -->
    <!-- {/block} -->
    </div>

</div>
<!-- {/block} -->