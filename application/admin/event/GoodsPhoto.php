<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/29
 * Time: 09:44
 */

namespace app\admin\event;


class GoodsPhoto
{
    public function beforeDelete($goodsPhoto)
    {
        $this->deleteGoodsPhoto($goodsPhoto);
    }

    //删除商品相册图片
    private function deleteGoodsPhoto($goodsPhoto)
    {
        if($goodsPhoto->og_photo){
            $thumb=[];
            $thumb[]='./uploads/'.$goodsPhoto->getData('og_photo');
            $thumb[]='./uploads/'.$goodsPhoto->getData('big_photo');
            $thumb[]='./uploads/'.$goodsPhoto->getData('mid_photo');
            $thumb[]='./uploads/'.$goodsPhoto->getData('sm_photo');

            foreach ($thumb as $k => $v) {
                if(file_exists($v)){
                    @unlink($v);
                }
            }
        }
    }


}