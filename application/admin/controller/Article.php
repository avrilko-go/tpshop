<?php

namespace app\admin\controller;

use app\admin\validate\ArticleCheck;
use app\admin\validate\IDCheck;
use app\lib\Utils;
use think\Controller;
use think\facade\Request;

class Article extends Controller
{
    /**
     * @return \think\response\View
     * @throws \think\exception\DbException
     * 文章列表
     */
    public function index()
    {
        //关联预查询
        $articles=\app\admin\model\Article::with('cate')->order('id','desc')->paginate(15);
        $this->assign(compact('articles'));
        return view();
    }

    /**
     * @return \think\response\View
     * 新增文章界面
     */
    public function create()
    {
        $caties=\app\admin\model\Cate::all();
        $caties=Utils::treeSort($caties);
        $this->assign(compact('caties'));
        return view();
    }

    /**
     * 新增文章操作
     */
    public function store()
    {
        //数据验证
        (new ArticleCheck())->goCheck();
        //新增操作
        $result=\app\admin\model\Article::storeArticle();
        if(!$result){
            $this->error('新增文章失败！');
        }
        $this->success('新增文章成功！','/admin/article');
    }

    /**
     * 编辑文章界面
     */
    public function edit(\app\admin\model\Article $article)
    {
        (new IDCheck())->goCheck();
        $caties=\app\admin\model\Cate::all();
        $caties=Utils::treeSort($caties);
        $this->assign(compact('article'));
        $this->assign(compact('caties'));
        return view();
    }

    /**
     * 编辑提交
     */
    public function update(\app\admin\model\Article $article)
    {
        (new IDCheck())->goCheck();
        (new ArticleCheck())->goCheck();
        $result= $article->updateArticle();
        if(!$result){
            $this->error('更新文章失败！');
        }
        $this->success('更新文章成功！','/admin/article');
    }


    //删除文章
    public function destroy(\app\admin\model\Article $article)
    {
        (new IDCheck())->goCheck();
        $result=$article->delete();
        if(!$result){
            $this->error('删除文章失败');
        }
        $this->success('删除文章成功','/admin/article');
    }

    /**
     * 管理ueditor上传的图片
     */
    public function image()
    {
        $imgs=Utils::scanDir('./ueditor/php/upload/image');
        $this->assign(compact('imgs'));
        return view();
    }

    /**
     * @return int
     * 删除ueditor图片操作
     */
    public function imageDelete()
    {
        $url=Request::delete('imgsrc');

        if(file_exists('.'.$url)){
            return unlink('.'.$url) ? 1 : 2;
        }
        return 0;
    }
}
