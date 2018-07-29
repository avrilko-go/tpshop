<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/27
 * Time: 22:07
 */

namespace app\admin\event;


class Type
{
    public function beforeDelete($type)
    {
        db('attr')->where('type_id',$type->id)->delete();
    }
}