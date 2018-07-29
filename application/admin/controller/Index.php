<?php
namespace app\admin\controller;

use think\Controller;
use think\facade\Cache;

class Index extends Controller
{
    public function index()
    {
        return view();
    }

    public function clearCache()
    {
        Cache::clear();
        $this->success('清除缓存成功');
    }


}
