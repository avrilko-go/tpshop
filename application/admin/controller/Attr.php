<?php

namespace app\admin\controller;

use app\admin\validate\AttrCheck;
use app\admin\validate\IDCheck;
use think\Controller;
use think\Request;

class Attr extends Controller
{
    /**
     * @return \think\response\View
     * @throws \think\exception\DbException
     * 商品属性列表
     */
    public function index()
    {
        if($this->request->get('type_id')){
            $attrs=\app\admin\model\Attr::with('type')->where('type_id',$this->request->get('type_id'))->order('id','desc')->paginate(15);
        }else{
            $attrs=\app\admin\model\Attr::with('type')->order('id','desc')->paginate(15);
        }

        $this->assign(compact('attrs'));
        return view();
    }

    /**
     * @return \think\response\View
     * 新增品牌界面
     */
    public function create()
    {
        $types=\app\admin\model\Type::all();

        $this->assign(compact('types'));

        return view();
    }

    /**
     * 新增品牌操作
     */
    public function store()
    {
        //数据验证
        (new AttrCheck())->goCheck();
        //新增操作
        $result=\app\admin\model\Attr::create($this->request->only(['attr_name','attr_type','attr_values','type_id']));
        if(!$result){
            $this->error('新增商品属性失败！');
        }
        $this->success('新增商品属性成功！','/admin/attr');
    }

    /**
     * 编辑品牌界面
     */
    public function edit(\app\admin\model\attr $attr)
    {
        (new IDCheck())->goCheck();
        $types=\app\admin\model\Type::all();

        $this->assign(compact('types'));
        $this->assign(compact('attr'));
        return view();
    }

    /**
     * 编辑提交
     */
    public function update(\app\admin\model\attr $attr)
    {
        (new IDCheck())->goCheck();
        (new AttrCheck())->goCheck();
        $result= $attr->save($this->request->only(['attr_name','attr_type','attr_values','type_id']));
        if(!$result){
            $this->error('更新商品属性失败！');
        }
        $this->success('更新商品属性成功！','/admin/attr');
    }


    //删除品牌
    public function destroy(\app\admin\model\Attr $attr)
    {
        (new IDCheck())->goCheck();
        $result=$attr->delete();
        if(!$result){
            $this->error('删除商品属性失败');
        }
        $this->success('删除商品属性成功','/admin/attr');
    }

    //ajax获取类型下所有属性
    public function type()
    {
        (new IDCheck())->goCheck();
        $result=\app\admin\model\Attr::where('type_id',$this->request->post('id'))->select();
        return $result;
    }

}
