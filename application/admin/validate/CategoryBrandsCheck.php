<?php
namespace app\admin\validate;

class CategoryBrandsCheck extends Base
{
    protected $rule =   [
        'brands_id'  => 'require',
        'category_id'  => 'require',
    ];
    
    protected $message  =   [
        'category_id.require' => '所属分类必须',
        'brands_id.require' => '关联品牌必须'
    ];


}