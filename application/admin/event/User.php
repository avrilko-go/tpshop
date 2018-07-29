<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/27
 * Time: 22:07
 */

namespace app\admin\event;


class User
{
    public function beforeInsert($user)
    {
        $user->register_time=time();
        $user->password=md5($user->password);
    }
}