<?php
namespace app\admin\validate;
use think\Validate;
class AlternateImg extends Base
{
    protected $rule =   [
        'title'  => 'require|unique:alternate_img',
    ];
    
    protected $message  =   [
        'title.require' => '标题必须',
        'title.unique'     => '标题不能重复',
    ];


}