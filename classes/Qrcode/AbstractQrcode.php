<?php

namespace Ecjia\App\Mobile\Qrcode;

abstract class AbstractQrcode 
{
    
    /**
     * 二维码中间logo图片
     * 
     * @var string
     */
    protected $logo;
    
    /**
     * ID
     *
     * @var integer
     */
    protected $id;
    
    public function __construct($id, $logo = null)
    {
        $this->id = $id;
        $this->logo = $logo;
    
        if (! is_dir($this->storeDir())) {
            RC_File::makeDirectory($this->storeDir(), 0777, true);
        }
    
        if (! RC_File::exists($this->getQrcodePath())) {
            $this->createQrcode();
        }
    }
    
    /**
     * 二维码内容
     */
    abstract public function content();
    
    /**
     * 二维码存储目录
     */
    abstract public function storeDir();
    
    /**
     * 二维码生成文件名
     */
    abstract public function fileName();
    
    /**
     * 移除二维码
     */
    public function removeQrcode()
    {
        if (RC_File::exists($this->getQrcodePath()))
            return RC_File::delete($this->getQrcodePath());
    }
    
    /**
     * 创建二维码
     * @param number $size
     */
    public function createQrcode($size = 430)
    {
        RC_QrCode::format('png')->size($size)->margin(1)
                    ->merge($this->logo, 0.2, true)
                    ->errorCorrection('H')
                    ->generate($this->content(), $this->getQrcodePath());
    }
    
    /**
     * 获取二维码Url
     * @return string
     */
    public function getQrcodeUrl()
    {
         return RC_Upload::upload_url() . str_replace(RC_Upload::upload_path(), '/', $this->storeDir()) . $this->fileName();
    }
    
    /**
     * 获取二维码文件路径
     * @return string
     */
    public function getQrcodePath()
    {
        return RC_Upload::upload_path() . $this->fileName();
    }
    
}

// end