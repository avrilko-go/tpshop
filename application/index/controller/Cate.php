<?php

namespace app\index\controller;

use think\facade\Request;

class Cate extends Base
{
    public function index()
    {
        $cates=\app\admin\model\Cate::with('child')->where(['cate_type'=>5,'pid'=>0])->select();

        $id=Request::get('id') ? Request::get('id') : 4;

        $cateArticles=\app\admin\model\Cate::with('article')->where('id',$id)->find();

        $this->assign(compact('cates','cateArticles'));

        return view();
    }
}
