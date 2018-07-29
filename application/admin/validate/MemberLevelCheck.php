<?php
namespace app\admin\validate;

class MemberLevelCheck extends Base
{
    protected $rule =   [
        'level_name'  => 'require|unique:member_level',
        'bom_point'  => 'require',
        'top_point'=>'require',
    ];
    
    protected $message  =   [
        'level_name.require' => '级别名称必须',
        'level_name.unique'     => '级别名称不能重复',
        'bom_point.require'=>'积分下限必须',
        'top_point.require'=>'积分上限必须',
    ];


}