<?php
namespace app\admin\validate;

use think\facade\Request;

class CategoryAdCheck extends Base
{
    protected $rule =   [
        'position'  => 'require|timesCheck',
        'category_id'  => 'require',
    ];
    
    protected $message  =   [
        'category_id.require' => '所属分类必须',
        'position.require' => '广告位置必须',
        'position.timesCheck'=>'单个分类A区图最多设置三张，B区和C区图最多设置一张'
    ];



    public function timesCheck($value,$rule)
    {
        $category_id=Request::param('category_id');
        switch ($value){
            case 'A':
                $count=db('category_ad')->where(['category_id'=>$category_id,'position'=>'A'])->count();
                if($count>=3){
                    return false;
                }
                break;
            case 'B':
                if(db('category_ad')->where(['category_id'=>$category_id,'position'=>'B'])->find()){
                    return false;
                }
                break;
            case 'C':
                if(db('category_ad')->where(['category_id'=>$category_id,'position'=>'C'])->find()){
                    return false;
                }
                break;
        }
        return true;
    }



}