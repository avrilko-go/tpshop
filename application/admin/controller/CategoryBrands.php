<?php

namespace app\admin\controller;

use app\admin\validate\CategoryBrandsCheck;
use app\admin\validate\IDCheck;
use think\Controller;

class CategoryBrands extends Controller
{
    /**
     * @return \think\response\View
     * @throws \think\exception\DbException
     * 品牌关联列表
     */
    public function index()
    {
        $categoryBrands=db('categoryBrands')
            ->field('cb.*,c.cate_name,GROUP_CONCAT(b.brand_name) brand_name')->alias('cb')
            ->join('category c',"cb.category_id = c.id")
            ->join('brand b',"find_in_set(b.id,cb.brands_id)",'LEFT')
            ->order('cb.id DESC')->group('cb.id')->paginate(6);
        $this->assign(compact('categoryBrands'));
        return view();
    }

    /**
     * @return \think\response\View
     * 新增品牌关联界面
     */
    public function create()
    {
        $categories=\app\admin\model\Category::where('pid',0)->select();
        $brands=\app\admin\model\Brand::where('brand_img','neq','')->select();
        $this->assign(compact('categories','brands'));
        return view();
    }

    /**
     * 新增品牌关联操作
     */
    public function store()
    {
        //数据验证
        (new CategoryBrandsCheck())->goCheck();
        //新增操作
        $result=\app\admin\model\CategoryBrands::storeCategoryBrands();
        if(!$result){
            $this->error('新增品牌关联失败！');
        }
        $this->success('新增品牌关联成功！','/admin/category_brands');
    }

    /**
     * 编辑品牌关联界面
     */
    public function edit(\app\admin\model\CategoryBrands $categoryBrands)
    {
        (new IDCheck())->goCheck();
        $categories=\app\admin\model\Category::where('pid',0)->select();
        $brands=\app\admin\model\Brand::where('brand_img','neq','')->select();
        $this->assign(compact('categoryBrands','categories','brands'));
        return view();
    }

    /**
     * 编辑提交
     */
    public function update(\app\admin\model\CategoryBrands $categoryBrands)
    {
        (new IDCheck())->goCheck();

        (new CategoryBrandsCheck())->goCheck();

        $result=$categoryBrands->updateCategoryBrands();
        if(!$result){
            $this->error('更新品牌关联失败！');
        }
        $this->success('更新品牌关联成功！','/admin/category_brands');
    }


    //删除品牌关联
    public function destroy(\app\admin\model\CategoryBrands $categoryBrands)
    {
        (new IDCheck())->goCheck();
        $result=$categoryBrands->delete();
        if(!$result){
            $this->error('删除品牌关联失败');
        }
        $this->success('删除品牌关联成功','/admin/category_brands');
    }
}
