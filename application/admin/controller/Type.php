<?php

namespace app\admin\controller;

use app\admin\validate\IDCheck;
use think\Controller;
use think\facade\Request;

class Type extends Controller
{
    /**
     * @return \think\response\View
     * @throws \think\exception\DbException
     * 商品类型列表
     */
    public function index()
    {
        $types=\app\admin\model\Type::order('id','desc')->paginate(10);
        $this->assign(compact('types'));
        return view();
    }

    /**
     * @return \think\response\View
     * 新增商品类型界面
     */
    public function create()
    {
        return view();
    }

    /**
     * 新增商品类型操作
     */
    public function store()
    {
        //新增操作
        $result=\app\admin\model\Type::create(Request::only(['type_name']));
        if(!$result){
            $this->error('新增商品类型失败！');
        }
        $this->success('新增商品类型成功！','/admin/type');
    }

    /**
     * 编辑商品类型界面
     */
    public function edit(\app\admin\model\Type $type)
    {
        (new IDCheck())->goCheck();
        $this->assign(compact('type'));
        return view();
    }

    /**
     * 编辑提交
     */
    public function update(\app\admin\model\Type $type)
    {
        $type->type_name=$this->request->put('type_name');
        $result= $type->save();
        if(!$result){
            $this->error('更新商品类型失败！');
        }
        $this->success('更新商品类型成功！','/admin/type');
    }


    //删除商品类型
    public function destroy(\app\admin\model\Type $type)
    {
        (new IDCheck())->goCheck();
        $result=$type->delete();
        if(!$result){
            $this->error('删除商品类型失败');
        }
        $this->success('删除商品类型成功','/admin/type');
    }
}
