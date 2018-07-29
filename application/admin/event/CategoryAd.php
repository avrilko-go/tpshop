<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/25
 * Time: 19:19
 */

namespace app\admin\event;


use app\lib\Utils;

class CategoryAd
{
    public function beforeInsert($categoryAd)
    {
        $this->checkUrl($categoryAd);

    }

    public function beforeUpdate($categoryAd)
    {
        $this->checkUrl($categoryAd);
    }

    public function beforeDelete($categoryAd)
    {
        @unlink('./uploads/'.$categoryAd->getData('img_src'));
    }
    

    public function checkUrl($categoryAd)
    {
        if($categoryAd->link_url){
            $categoryAd->link_url=Utils::urlChange($categoryAd->link_url);
        }
    }


}