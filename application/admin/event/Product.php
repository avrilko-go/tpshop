<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/26
 * Time: 16:46
 */

namespace app\admin\event;


class Product
{
    public function beforeInsert($product)
    {
        if(is_array($product->goods_attr)){
            $product->goods_attr=implode(',',$product->goods_attr);
        }
    }


}