<?php

class mobile_qrcode
{
    
    public static function getApiUrl()
    {
        RC_Package::package('app::touch')->loadClass('ecjia_touch_manager', false);
        $url = with(new ecjia_touch_manager())->serverHost();
        return $url;
    }
    
    /**
     * 创建二维码并保存
     * @param string $url
     * @param number $size
     */
    public static function createStreetQrcode($url, $size = 512)
    {
        
        $mobile_app_icon = ecjia_config::get('mobile_app_icon');
        $icon_path = RC_Upload::upload_path().$mobile_app_icon;

        $save_dir = RC_Upload::upload_path().'data/qrcodes/';
        
        $save_path = $save_dir.'street_qrcode_'.$size.'.png';
        
        if (! is_dir($save_dir)) {
            RC_File::makeDirectory($save_dir);
        }
        
        RC_QrCode::format('png')->size($size)->margin(1)
                    ->merge($icon_path, 0.2, true)
                    ->errorCorrection('H')
                    ->generate($url, $save_path);
        
    }
    
    /**
     * 获取二维码的Url
     * @param number $size
     * @return string
     */
    public static function getStreetQrcodeUrl($size)
    {
        $file_path = RC_Upload::upload_path().'data/qrcodes/street_qrcode_'.$size.'.png';
        
        if (RC_File::exists($file_path))
        {
            $url = RC_Upload::upload_url().'/data/qrcodes/street_qrcode_'.$size.'.png';
        }
        else 
        {
            $url = RC_Upload::upload_url().'/data/qrcodes/street_qrcode_512.png';
        }

        return $url;
    }
    
    
    /**
     * 获取二维码的Path
     * @param number $size
     * @return string
     */
    public static function getStreetQrcodePath($size)
    {
        $file_path = RC_Upload::upload_path().'data/qrcodes/street_qrcode_'.$size.'.png';
    
        if (! RC_File::exists($file_path))
        {
            $file_path = RC_Upload::upload_path().'data/qrcodes/street_qrcode_512.png';
        }
    
        return $file_path;
    }
    
}

// end