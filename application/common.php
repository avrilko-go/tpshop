<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------



/**
 * @param $str
 * @param int $lenth
 * @return string
 * 截取字符串，多余的用省略号代替
 */
function cut_str($str,$lenth=10){
    if(mb_strlen($str)>$lenth){
        return mb_substr($str,0,$lenth).'...';
    }else{
        return $str;
    }
}