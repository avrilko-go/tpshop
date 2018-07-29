<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/25
 * Time: 19:19
 */

namespace app\admin\event;


use app\lib\Utils;

class CategoryWords
{
    public function beforeInsert($categoryWord)
    {
        $this->checkUrl($categoryWord);
    }

    public function beforeUpdate($categoryWord)
    {
        $this->checkUrl($categoryWord);
    }
    

    public function checkUrl($categoryWord)
    {
        if($categoryWord->link_url){
            $categoryWord->link_url=Utils::urlChange($categoryWord->link_url);
        }
    }


}