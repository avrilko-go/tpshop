<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/26
 * Time: 16:46
 */

namespace app\admin\event;


use app\lib\Utils;

class Article
{
    public function beforeInsert($article)
    {
        $this->checkUrl($article);
        $article->addtime=time();
    }

    public function beforeDelete($article)
    {
        @unlink('./uploads/'.$article->getData('thumb'));
    }

    public function beforeUpdate($article)
    {
        $this->checkUrl($article);
    }

    public function checkUrl($article)
    {
        if($article->link_url){
            $article->link_url=Utils::urlChange($article->link_url);
        }
    }
}