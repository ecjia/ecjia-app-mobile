<?php

namespace Ecjia\App\Mobile\Qrcode;

class GenerateGoods extends AbstractQrcode {

    /**
     * 商品ID
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
            'open_type'     => 'goods_detail',
            'goods_id'      => $this->id
            ];
        return RC_Uri::url('mobile/redirect/init', $args);
    }


    public function storeDir()
    {
        $dir = RC_Upload::upload_path().'data/qrcodes/goods/';

        if (! is_dir($dir)) {
            RC_File::makeDirectory($dir, 0777, true);
        }

        return $dir;
    }


    public function fileName()
    {
        return 'goods_' . $this->id . '.png'';
    }

}