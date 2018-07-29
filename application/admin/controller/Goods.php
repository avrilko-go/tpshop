<?php

namespace app\admin\controller;


use app\admin\model\GoodsAttr;
use app\admin\model\GoodsPhoto;
use app\admin\model\Product;
use app\admin\validate\GoodsCheck;
use app\admin\validate\IDCheck;
use app\lib\Utils;
use think\Controller;
use think\facade\Request;

class Goods extends Controller
{
    /**
     * 商品列表
     */
    public function index()
    {
        //关联预查询解决n+1
        $goodes=\app\admin\model\Goods::with(['product'=>function($query){
            $query->field('goods_id,sum(goods_number) as sumProduct')->group('goods_id');
        }])->with(['type','brand','category'])->order('id','desc')->paginate(10);

        //闭包闭包闭包  重要的事说三遍
        $this->assign(compact('goodes'));
        return view();
    }

    /**
     * 商品添加界面
     */
    public function create()
    {
        //获取所有商品品牌
        $brands=\app\admin\model\Brand::all();

        //获取所有会员级别
        $memberLevels=\app\admin\model\MemberLevel::all();

        //获取所有商品类型
        $types=\app\admin\model\Type::all();

        //获取所有商品推荐位
        $recpoes=\app\admin\model\Recpos::where('rec_type',1)->select();

        //获取所有商品栏目
        $categories=\app\admin\model\Category::all();
        //无限极排序
        $categories=Utils::treeSort($categories);

        $this->assign(compact('categories','brands','memberLevels','types','recpoes'));
        return view();
    }

    /**
     * 商品添加操作
     */
    public function store()
    {
        (new GoodsCheck())->goCheck();
        $result=\app\admin\model\Goods::createGoods();
        if(!$result){
            $this->error('添加商品失败');
        }
        $this->success('添加商品成功','/admin/goods');

    }

    /**
     * @param \app\admin\model\Goods $goods
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 商品编辑
     */
    public function edit(\app\admin\model\Goods $goods)
    {
        $goods=$goods->with(['memberPrice','goodsPhoto'])->where('id',$goods->id)->find();

        //获取当前商品分类下的所有属性
        $attrsAll=\app\admin\model\Attr::where('type_id',$goods->type_id)->select();

        //获取所有商品分类下已经添加的属性,并组合为3维数组
        $__attrAlready=GoodsAttr::where('goods_id',$goods->id)->select();
        $attrAlready=[];
        foreach ($__attrAlready as $k=>$v){
            $attrAlready[$v['attr_id']][]=$v;
        }

        //获取当前商品所有的推荐位,拆分为一维数组
        $__goodRecpoes=db('rec_item')->where(['value_id'=>$goods->id,'value_type'=>1])->select();
        $goodRecpoes=[];
        foreach ($__goodRecpoes as $k=>$v){
            $goodRecpoes[]=$v['recpos_id'];
        }

        //获取所有商品推荐位
        $recpoes=\app\admin\model\Recpos::where('rec_type',1)->select();

        //获取所有商品品牌
        $brands=\app\admin\model\Brand::all();

        //获取所有会员级别
        $memberLevels=\app\admin\model\MemberLevel::all();

        //获取所有商品类型
        $types=\app\admin\model\Type::all();

        //获取所有商品栏目
        $categories=\app\admin\model\Category::all();
        //无限极排序
        $categories=Utils::treeSort($categories);

        $this->assign(compact('categories','goodRecpoes','brands','memberLevels','types','goods','attrsAll','attrAlready','recpoes'));
        return view();
    }


    /**
     * @param \app\admin\model\Goods $goods
     * @throws \app\exception\ParamsException
     * 更新商品信息
     */
    public function update(\app\admin\model\Goods $goods)
    {
        (new IDCheck())->goCheck();
        $goods->updateGoods();
        $this->success('更新商品信息成功','/admin/goods');
    }



    /**
     * @param \app\admin\model\Goods $goods
     * @throws \Exception
     * @throws \app\exception\ParamsException
     * 删除商品操作
     */
    public function destroy(\app\admin\model\Goods $goods)
    {
        (new IDCheck())->goCheck();
        $result=$goods->delete();
        if(!$result){
            $this->error('删除商品失败');
        }
        $this->success('删除商品成功');
    }


    //商品库存列表
    public function product()
    {
        (new IDCheck())->goCheck();
        $id=Request::get('id');
        $products=Product::where('goods_id',$id)->select();

        $__radios=GoodsAttr::with(['attr'=>function($query){
            $query->where('attr_type',1);
        }])->where('goods_id',$id)->select();

        $radios=[];

        foreach ($__radios as $k=>$v){
            $radios[$v['attr']['attr_name']][]=$v;
        }
        $this->assign(compact('products','radios','id'));
        return view();

    }

    //商品库存新增或更新
    public function productChange($id)
    {
        (new IDCheck())->goCheck();

        Product::destroy(function ($query) use($id) {
            $query->where('goods_id',$id);
        });

        $goods_attr=Request::post('goods_attr');

        $goods_num=Request::post('goods_num');

        foreach ($goods_num as $k =>$v){
            $arr=[];
            foreach ($goods_attr as $k1=>$v1){
                if(empty($v1[$k])){
                    continue 2;
                }
                array_push($arr,$v1[$k]);
            }
            Product::create([
                'goods_id'=>$id,
                'goods_number'=>$v,
                'goods_attr'=>$arr
            ]);
        }
        $this->success('商品库存操作成功！');
    }

    //ajax删除单个图
    public function deleteImage(GoodsPhoto $goodsPhoto)
    {
        $result=$goodsPhoto->delete();
        if(!$result){
            return 2;
        }
        return 1;
    }

}
