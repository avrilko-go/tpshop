<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/25
 * Time: 19:19
 */

namespace app\admin\event;


use app\lib\Utils;

class CategoryBrands
{
    public function beforeInsert($categoryBrand)
    {
        $categoryBrand->brands_id=implode(',',$categoryBrand->brands_id);
        $this->checkUrl($categoryBrand);

    }

    public function beforeUpdate($categoryBrand)
    {
        $categoryBrand->brands_id=implode(',',$categoryBrand->brands_id);
        $this->checkUrl($categoryBrand);
    }

    public function beforeDelete($categoryBrand)
    {
        @unlink('./uploads/'.$categoryBrand->getData('pro_img'));
    }
    

    public function checkUrl($categoryBrand)
    {
        if($categoryBrand->pro_url){
            $categoryBrand->pro_url=Utils::urlChange($categoryBrand->pro_url);
        }
    }


}