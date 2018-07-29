<?php

namespace app\Index\controller;

use think\Controller;

class User extends Base
{
    public function show(\app\admin\model\User $user)
    {
        $this->assign(compact('user'));
        return view();
    }
}
