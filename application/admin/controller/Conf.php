<?php

namespace app\admin\controller;

use app\admin\validate\ConfCheck;
use app\admin\validate\IDCheck;
use app\admin\validate\SortCheck;
use think\Controller;
use think\Db;
use think\Exception;
use think\facade\Request;

class Conf extends Controller
{
    /**
     * @return \think\response\View
     * @throws \think\exception\DbException
     * 配置列表
     */
    public function index()
    {
        $confs=\app\admin\model\Conf::order('sort','desc')->paginate(15);
        $this->assign(compact('confs'));
        return view();
    }

    /**
     * @return \think\response\View
     * 新增配置界面
     */
    public function create()
    {
        return view();
    }

    /**
     * 新增配置操作
     */
    public function store()
    {
        //数据验证
        (new ConfCheck())->goCheck();
        //新增操作
        $result=\app\admin\model\Conf::storeConf();
        if(!$result){
            $this->error('新增配置失败！');
        }
        $this->success('新增配置成功！','/admin/conf');
    }

    /**
     * 编辑配置界面
     */
    public function edit(\app\admin\model\Conf $conf)
    {
        (new IDCheck())->goCheck();
        $this->assign(compact('conf'));
        return view();
    }

    /**
     * 编辑提交
     */
    public function update(\app\admin\model\Conf $conf)
    {
        (new ConfCheck())->goCheck();
        $result= $conf->updateConf();
        if(!$result){
            $this->error('更新配置失败！');
        }
        $this->success('更新配置成功！','/admin/conf');
    }


    //删除配置
    public function destroy(\app\admin\model\Conf $conf)
    {
        (new IDCheck())->goCheck();
        $result=$conf->delete();
        if(!$result){
            $this->error('删除配置失败');
        }
        $this->success('删除配置成功','/admin/conf');
    }

    /**
     * 配置ajax排序
     */
    public function sort(\app\admin\model\Conf $conf)
    {
        (new SortCheck())->goCheck();
        $conf->sort=Request::post('sort');
        $result=$conf->save();
        if($result){
            return json([
                'status'=>1,
                'msg'=>'排序成功'
            ]);
        }else{
            return json([
                'status'=>0,
                'msg'=>'排序失败'
            ]);
        }
    }

    /**
     * 所有配置项目列表
     */
    public function conflist()
    {
        $shopList=\app\admin\model\Conf::where('conf_type',1)->order('sort','desc')->select();
        $goodList=\app\admin\model\Conf::where('conf_type',2)->order('sort','desc')->select();
        $this->assign(compact('shopList'));
        $this->assign(compact('goodList'));
        return view();
    }

    /**
     * 保存配置信息
     */
    public function conflistUpdate()
    {
        Db::startTrans();
        try{
            $data=$this->request->except(['_method']);
            foreach ($data as $k => $v){
                $conf=\app\admin\model\Conf::where('ename',$k)->find();
                $conf->value=$v;
                $conf->save();
            }
            //checkbox置空
            \app\admin\model\Conf::updateEmptyCheckbox($data);

            //多图上传
            \app\admin\model\Conf::uploadImages();
            Db::commit();
            $this->success('修改配置成功');
        }catch (Exception $e){
            Db::rollback();
            $this->error($e->getMessage());
        }


    }
}
