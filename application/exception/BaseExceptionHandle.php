<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/26
 * Time: 12:23
 */

namespace app\exception;
use Exception;
use think\exception\Handle;

class BaseExceptionHandle extends Handle
{
    /**
     * @param Exception $e
     * @return \think\Response|\think\response\Json
     * 重写异常基类，方便统一输出
     */
    public function render(Exception $e)
    {
        if($e instanceof ParamsException){
            //如果为验证ajax异常，返回json
            return json([
                'status'=>0,
                'msg'=>$e->msg
            ]);
        }
        return parent::render($e);
    }
}