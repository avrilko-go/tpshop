<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/25
 * Time: 19:19
 */

namespace app\admin\event;


use app\lib\Utils;

class Link
{
    public function beforeInsert($link)
    {
        $this->checkUrl($link);
    }

    public function beforeUpdate($link)
    {
        $this->checkUrl($link);
    }

    public function beforeDelete($link)
    {
        @unlink('./uploads/'.$link->getData('logo'));
    }

    public function checkUrl($link)
    {
        if($link->link_url){
            $link->link_url=Utils::urlChange($link->link_url);
        }
    }


}