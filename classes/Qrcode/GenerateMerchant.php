<?php

RC_Package::package('app::mobile')->loadClass('generate_qrcode', false);

class generate_qrcode_merchant extends generate_qrcode {
    
    /**
     * 商家ID
     * 
     * @var integer
     */
    protected $id;

    
    public function content($id, $logo = null)
    {
        $this->id = $id;
        $this->logo = $logo;
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