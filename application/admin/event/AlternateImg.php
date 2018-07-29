<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/7/4
 * Time: 10:14
 */

namespace app\admin\event;


use app\lib\Utils;

class AlternateImg
{
    public function beforeInsert($alterbanteImg)
    {
        $this->checkUrl($alterbanteImg);
    }

    public function beforeDelete($alterbanteImg)
    {
        @unlink('./uploads/'.$alterbanteImg->getData('img_src'));
    }

    public function beforeUpdate($alterbanteImg)
    {
        $this->checkUrl($alterbanteImg);
    }

    public function checkUrl($alterbanteImg)
    {
        if($alterbanteImg->link_url){
            $alterbanteImg->link_url=Utils::urlChange($alterbanteImg->link_url);
        }
    }
}