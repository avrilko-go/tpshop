<?php
namespace app\admin\validate;
use think\Validate;
class IDCheck extends Base
{

    public function __construct($ajax=false, array $rules = [], array $message = [], array $field = [])
    {
        $this->ajax=$ajax;
        parent::__construct($rules, $message, $field);
    }


    protected $rule =   [
        'id'  => 'require|mustInterger',

    ];
    
    protected $message  =   [
        'id.require' => 'id必须传递',
        'id.mustInterger' => 'id必须为正整数',
    ];


}