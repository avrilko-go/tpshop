<?php

namespace app\admin\controller;

use app\admin\validate\IDCheck;
use think\Controller;

class GoodsAttr extends Controller
{

    /**
     * @param \app\admin\model\GoodsAttr $goodsAttr
     * @return int
     * @throws \Exception
     * @throws \app\exception\ParamsException
     * 删除操作
     */
    public function destroy(\app\admin\model\GoodsAttr $goodsAttr)
    {
        (new IDCheck(true))->goCheck();
        $result=$goodsAttr->delete();
        if(!$result){
            return 2;
        }
        return 1;
    }
}
