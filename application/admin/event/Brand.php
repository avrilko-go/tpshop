<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/25
 * Time: 19:19
 */

namespace app\admin\event;


use app\lib\Utils;

class Brand
{
    public function beforeInsert($brand)
    {
        $this->checkUrl($brand);
    }

    public function beforeUpdate($brand)
    {
        $this->checkUrl($brand);
    }

    public function beforeDelete($brand)
    {
        @unlink('./uploads/'.$brand->getData('brand_img'));
    }

    public function checkUrl($brand)
    {
        if($brand->brand_url){
            $brand->brand_url=Utils::urlChange($brand->brand_url);
        }
    }



}