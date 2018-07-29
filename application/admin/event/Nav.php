<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/26
 * Time: 16:46
 */

namespace app\admin\event;


use app\lib\Utils;

class Nav
{
    public function beforeInsert($nav)
    {
        $this->checkUrl($nav);
    }

    public function beforeUpdate($nav)
    {
        $this->checkUrl($nav);
    }

    public function checkUrl($nav)
    {
        if($nav->nav_url){
            $nav->nav_url=Utils::urlChange($nav->nav_url);
        }
    }
}