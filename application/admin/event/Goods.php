<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/26
 * Time: 16:46
 */

namespace app\admin\event;


use app\admin\model\GoodsAttr;
use app\admin\model\GoodsPhoto;
use app\admin\model\MemberPrice;
use think\facade\Request;
use think\Log;

class Goods
{
    public function beforeInsert($good)
    {
        $good->goods_code=time().rand(10000,99999);
    }

    public function afterInsert($good)
    {
        //处理会员价添加
        $this->createMemberPrice($good);
        //商品相册处理
        $this->createGoodPhoto($good);
        //处理商品属性
        $this->createGoodAttr($good);
        //处理商品推荐位
        $this->createGoodRecpos($good);
    }

    public function beforeUpdate($good)
    {
        //先删除会员价格再新增  简化更新操作
        $this->deleteMemberPrice($good);
        $this->createMemberPrice($good);

        //先删除商品推荐位再添加，简化操作
        $this->deleteGoodRecpos($good);
        $this->createGoodRecpos($good);
        //商品相册处理
        $this->createGoodPhoto($good);

        //处理商品属性
        $this->createGoodAttr($good);
        $this->updateGoodAttr($good);
    }


    public function beforeDelete($good)
    {
        //删除商品缩约图
        $this->deleteGoodThumb($good);
        //删除商品相册
        $this->deleteGoodPhoto($good);
        //删除关联的会员价格
        MemberPrice::destroy(function ($query) use ($good) {
            $query->where('goods_id',$good->id);
        });
        //删除商品的关联属性
        GoodsAttr::destroy(function ($query) use ($good) {
            $query->where('goods_id',$good->id);
        });

        //删除商品推荐
        $this->deleteGoodRecpos($good);

        //删除商品推荐
        db('rec_item')->where(['value_type'=>1,'value_id'=>$good->id])->delete();

    }


    //会员价增加
    private function createMemberPrice($good)
    {
        $data=Request::post('mp');

        foreach ($data as $k=>$v){
            if(trim($v)){
                MemberPrice::create([
                    'goods_id'=>$good->id,
                    'mprice'=>$v,
                    'mlevel_id'=>$k
                ]);
            }
        }
    }

    //删除会员价格
    private function deleteMemberPrice($good)
    {
        MemberPrice::destroy(function ($query) use ($good) {
            $query->where('goods_id',$good->id);
        });
    }

    //商品相册处理
    private function createGoodPhoto($good)
    {
        $files=Request::file('goods_photo');
        if($files){
            foreach ($files as $k=>$file){
                if($file){
                    $result=\app\admin\model\Goods::makeThumb($file);
                    GoodsPhoto::create([
                        'goods_id'=>$good->id,
                        'sm_photo'=>$result['sm_thumb'],
                        'mid_photo'=>$result['mid_thumb'],
                        'big_photo'=>$result['big_thumb'],
                        'og_photo'=>$result['og_thumb']
                    ]);
                }
            }
        }
    }

    //处理商品属性
    private function createGoodAttr($good)
    {
        $goodAttr = Request::post('goods_attr');
        $attrPrice = Request::post('attr_price');
        if(!empty($goodAttr)){
            $i=0;
            foreach ($goodAttr as $k=>$v){
                if(is_array($v)){
                    foreach ($v as $k1=>$v1){
                        if($v1){
                            GoodsAttr::create([
                                'attr_id'=>$k,
                                'attr_value'=>$v1,
                                'goods_id'=>$good->id,
                                'attr_price'=>$attrPrice[$i],
                            ]);
                            $i++;
                        }else{
                            $i++;
                            continue;
                        }
                    }
                }else{
                    GoodsAttr::create([
                        'attr_id'=>$k,
                        'attr_value'=>$v,
                        'goods_id'=>$good->id,
                        'attr_price'=>0
                    ]);
                }
            }
        }
    }

    //更新商品属性
    private function updateGoodAttr($good)
    {
        $goodAttr = Request::post('old_goods_attr');
        $attrPrice = Request::post('old_attr_price');

        if(!empty($goodAttr)){
            $keyArr=array_keys($attrPrice);
            $valuesArr=array_values($attrPrice);
            $i=0;
            foreach ($goodAttr as $k=>$v){
                if(is_array($v)){
                    foreach ($v as $k1=>$v1){
                        if($v1){
                            GoodsAttr::update([
                                'id'=>$keyArr[$i],
                                'attr_value'=>$v1,
                                'attr_price'=>$valuesArr[$i]
                            ]);
                            $i++;
                        }else{
                            $i++;
                            continue;
                        }
                    }
                }else{
                    GoodsAttr::update([
                        'id'=>$keyArr[$i],
                        'attr_value'=>$v,
                        'attr_price'=>$valuesArr[$i]
                    ]);
                    $i++;
                }
            }
        }
    }

    //删除商品缩略图
    private function deleteGoodThumb($good)
    {
        if($good->og_thumb){
            $thumb=[];
            $thumb[]='./uploads/'.$good->getData('og_thumb');
            $thumb[]='./uploads/'.$good->getData('big_thumb');
            $thumb[]='./uploads/'.$good->getData('mid_thumb');
            $thumb[]='./uploads/'.$good->getData('sm_thumb');

            foreach ($thumb as $k => $v) {
                if(file_exists($v)){
                    @unlink($v);
                }
            }
        }
    }

    //删除商品相册信息
    private function deleteGoodPhoto($good)
    {
        GoodsPhoto::destroy(function ($query) use ($good)  {
            $query->where('goods_id',$good->id);
        });
    }

    //增加商品推荐位
    private function createGoodRecpos($good)
    {
        $recpos=Request::post('recpos');
        if($recpos){
            foreach ($recpos as $k => $v){
                db('rec_item')->insert(['recpos_id'=>$v,'value_id'=>$good->id,'value_type'=>1]);
            }
        }
    }

    //删除商品推荐位
    private function deleteGoodRecpos($good)
    {
        db('rec_item')->where(['value_id'=>$good->id,'value_type'=>1])->delete();
    }

}