<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/26
 * Time: 12:25
 */

namespace app\exception;


class ParamsException extends \Exception
{
    public $msg='参数错误';

    public function __construct($msg='')
    {
        $this->msg=$msg;
    }
}