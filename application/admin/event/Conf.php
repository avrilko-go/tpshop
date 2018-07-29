<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/26
 * Time: 16:46
 */

namespace app\admin\event;

class Conf
{
    public function beforeInsert($conf)
    {
        $this->changeValues($conf);
    }



    public function beforeUpdate($conf)
    {
        if(is_array($conf->value)){
            $conf->value=implode(',',$conf->value);
        }

        $this->changeValues($conf);
    }

    /**
     * @param $conf
     * 将中文的逗号转换为英文的
     */
    private function changeValues($conf)
    {
        if($conf->values){
            $conf->values=str_replace('，',',',$conf->values);
        }

        if($conf->value){
            $conf->value=str_replace('，',',',$conf->value);
        }
    }


}