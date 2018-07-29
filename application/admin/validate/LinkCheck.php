<?php
namespace app\admin\validate;
use think\Validate;
class LinkCheck extends Base
{
    protected $rule =   [
        'title'  => 'require|unique:link',
        'link_url'   => 'require',
        'description' => 'min:6',
    ];
    
    protected $message  =   [
        'title.require' => '友情链接名称必须',
        'title.unique'     => '友情链接名称不能重复',
        'link_url.url'   => 'url格式不正确',
        'description.min'  => '描述最少6个字符',
    ];


}