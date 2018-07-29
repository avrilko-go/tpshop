<?php
namespace app\admin\validate;

class CategoryCheck extends Base
{
    protected $rule =   [
        'cate_name'  => 'require'
    ];
    
    protected $message  =   [
        'cate_name.require' => '商品分类标题必须',
    ];


}