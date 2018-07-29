<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/26
 * Time: 16:46
 */

namespace app\admin\event;


class Attr
{
    public function beforeInsert($attr)
    {
        if($attr->attr_values){
            $attr->attr_values=str_replace('，',',',$attr->attr_values);
        }
    }



    public function beforeUpdate($attr)
    {
        if($attr->attr_values){
            $attr->attr_values=str_replace('，',',',$attr->attr_values);
        }
    }


}