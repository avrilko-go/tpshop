<?php

namespace app\index\controller;

use app\lib\Utils;

class Article extends Base
{
    public function index(\app\admin\model\Article $article)
    {
        $cates=\app\admin\model\Cate::with('child')->where(['cate_type'=>5,'pid'=>0])->select();

        $position=$article->getPosition();
        $this->assign(compact('cates','article','position'));
        return view();
    }
}
