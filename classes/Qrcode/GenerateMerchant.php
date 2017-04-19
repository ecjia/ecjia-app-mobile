<?php

namespace Ecjia\App\Mobile\Qrcode;

class GenerateMerchant extends AbstractQrcode {
    
    /**
     * 商家ID
     * 
     * @var integer
     */
    protected $id;

    
    public function __construct($id, $logo = null)
    {
        $this->id = $id;
        $this->logo = $logo;
    }
    
    
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
        
        if (! is_dir($dir)) {
            RC_File::makeDirectory($dir, 0777, true);
        }
        
        return $dir;
    }
    
    
    public function fileName()
    {
        return 'merchant_' . $this->id . '.png'';
    }
    
}