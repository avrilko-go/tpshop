<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/26
 * Time: 12:02
 */

namespace app\admin\validate;


class SortCheck extends Base
{
    protected $ajax=true;

    protected $rule =   [
        'id'  => 'require|mustInterger',
        'sort'  => 'require|mustInterger',
    ];

    protected $message  =   [
        'id.require' => '分类id必须传递',
        'sort.require' => '排序大小必须传递',
        'id.mustInterger'     => 'id必须为正整数',
        'sort.mustInterger'     => 'sort必须为正整数',
    ];
}