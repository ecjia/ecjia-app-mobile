<?php

namespace Ecjia\App\Mobile\Qrcode;

use RC_Upload;
use RC_Uri;

class GenerateGoods extends AbstractQrcode {
    
    public function content()
    {
        $args = [
            'handle'        => 'ecjiaopen',
            'open_type'     => 'goods_detail',
            'goods_id'      => $this->id
        ];
        return RC_Uri::url('mobile/redirect/init', $args);
    }


    public function storeDir()
    {
        $dir = RC_Upload::upload_path().'data/qrcodes/goods/';

        return $dir;
    }


    public function fileName()
    {
        return 'goods_' . $this->id . '.png';
    }

}

// end