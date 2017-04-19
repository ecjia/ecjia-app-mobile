<?php

RC_Package::package('app::mobile')->loadClass('generate_qrcode', false);

class generate_qrcode_goods extends generate_qrcode {

    /**
     * 商品ID
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