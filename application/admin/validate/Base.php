<?php
namespace app\admin\validate;

use app\exception\ParamsException;
use think\facade\Request;
use think\Validate;
use traits\controller\Jump;

class Base extends Validate
{
    use Jump;
    protected $ajax=false;

    /**
     * @param Request $request
     * 建立验证基类，方便数据验证
     */
    public function goCheck()
    {

        $params=Request::param();
        //如果为ajax异常则抛出验证ajax异常，普通的则跳转错误页面
        if(!$this->check($params)){
            if($this->ajax){
                throw new ParamsException($this->error);
            }else{
                $this->error($this->error);
            }
        }
        return true;
    }

    /**
     * @param $value
     * @param $rule
     * @return bool
     * 验证传入的值是否为正整数
     */
    public function mustInterger($value,$rule)
    {
        if(!preg_match("/^[1-9][0-9]*$/",$value)){
            return false;
        }
        return true;

    }

}