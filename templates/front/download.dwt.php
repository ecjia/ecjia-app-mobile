<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,minimal-ui" name="viewport">
    <title>{$page_title}</title>
    <style>
        {literal}
        body{margin:0;padding:0;background-color: #148ac3;font-family: "微软雅黑";}
        .pic{min-height: 250px;position: relative;}
        .pic .icon{position: absolute; width: 24%;top: 34%;left: 38%;}
		.pic p{font-size: 1em;text-align: center;position: absolute;top: 60%;width: 90%;margin: 0 5%;}
        .btns{position: relative;}
        .btns a {height: 17%;left: 15.6%;position: absolute;width: 68.8%; margin-top: -2px;}
        .btns a.disabled {cursor: default;background: #148ac3;}
        .btns img{border: 0 none;display: block;}
        .android {top: 18.37%;}
        .iphone {top: 42.86%;}
        .ipad {top: 67.35%;}
        .close {display:block;cursor:pointer;position:absolute;top:0;right:0;width:1.2em;height:1.2em;padding: 0 0 0.2em 0.2em;text-align:center;border-bottom-left-radius:1em;font-size:1.2em;color:#fff;background:#148ac3;text-decoration: none;}
        {/literal}
    </style>
</head>
<body>
    <div class="pic">
        <img width="100%" src="{$front_url}/image/download_bj.png">
        <div class="icon">
            <img width="100%" src="{$shop_app_icon}" />
        </div>
        <p>{$shop_app_description}</p>
        <a class="close" href="{$shop_url}">x</a>
    </div>
    <div class="btns">
        <img src="{$front_url}/image/download_url.png" width="100%">
        {if $shop_android_download eq ''}<a class="android downloadBtns disabled" href="javascript:;"></a>{else}<a class="android downloadBtns" href="{$shop_android_download}"></a>{/if}
        {if $shop_iphone_download eq ''}<a class="iphone downloadBtns disabled" href="javascript:;"></a>{else}<a class="iphone downloadBtns" href="{$shop_iphone_download}"></a>{/if}
        {if $shop_ipad_download eq ''}<a class="ipad downloadBtns disabled" href="javascript:;"></a>{else}<a class="ipad downloadBtns" href="{$shop_ipad_download}"></a>{/if}
    </div>
</body>
