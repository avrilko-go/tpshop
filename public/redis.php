<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/7/26
 * Time: 09:03
 */

class Test {
    private static $arr=[
        '体力'=>'send1',
        '客服'=>'send2'
    ];

    public static function send($k){
        $action=self::$arr[$k];
        self::$action();
    }


    private static function send1(){
        echo 1;
    }

    private static function send2(){
        echo 2;
    }

}

Test::send('体力');
echo 111;

