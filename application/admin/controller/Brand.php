<?php

namespace app\admin\controller;

use app\admin\validate\BrandCheck;
use app\admin\validate\IDCheck;
use think\Controller;


class Brand extends Controller
{
    /**
     * @return \think\response\View
     * @throws \think\exception\DbException
     * 商品品牌列表
     */
    public function index()
    {
        $brands=\app\admin\model\Brand::order('id','desc')->paginate(15);
        $this->assign(compact('brands'));
        return view();
    }

    /**
     * @return \think\response\View
     * 新增品牌界面
     */
    public function create()
    {
        return view();
    }

    /**
     * 新增品牌操作
     */
    public function store()
    {
        //数据验证
        (new BrandCheck())->goCheck();
        //新增操作
        $result=\app\admin\model\Brand::storeBrand();
        if(!$result){
            $this->error('新增商品品牌失败！');
        }
        $this->success('新增商品品牌成功！','/admin/brand');
    }

    /**
     * 编辑品牌界面
     */
    public function edit(\app\admin\model\Brand $brand)
    {
        (new IDCheck())->goCheck();
        $this->assign(compact('brand'));
        return view();
    }

    /**
     * 编辑提交
     */
    public function update(\app\admin\model\Brand $brand)
    {
        (new IDCheck())->goCheck();
        (new BrandCheck())->goCheck();
        $result= $brand->updateBrand();
        if(!$result){
            $this->error('更新商品品牌失败！');
        }
        $this->success('更新商品品牌成功！','/admin/brand');
    }


    //删除品牌
    public function destroy(\app\admin\model\Brand $brand)
    {
        (new IDCheck())->goCheck();
        $result=$brand->delete();
        if(!$result){
            $this->error('删除商品品牌失败');
        }
        $this->success('删除商品品牌成功','/admin/brand');
    }

}
