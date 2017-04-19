<?php

namespace Ecjia\App\Mobile\Qrcode;

class GenerateMerchant extends AbstractQrcode {
        
    public function content()
    {
        $args = [
            'handle'        => 'ecjiaopen', 
            'open_type'     => 'merchant', 
            'merchant_id'   => $this->id
        ];
        return RC_Uri::url('mobile/redirect/init', $args);
    }
    
    public function storeDir() 
    {
        $dir = RC_Upload::upload_path().'data/qrcodes/merchants/';

        return $dir;
    }
    
    
    public function fileName()
    {
        return 'merchant_' . $this->id . '.png'';
    }
    
}

// end