<?php
namespace app\index\controller;

use app\admin\model\Cate;
use app\admin\model\Nav;
use app\index\service\Common;
use think\Controller;
use think\facade\Cache;
use think\facade\Cookie;
use think\facade\Session;

class Base extends Controller
{
    protected $config;

    public function initialize()
    {
        //网站配置信息
        $config=Common::getConfig();

        $is_login=Common::checkLogin();

        //页脚分类数据
        $helpCateArticle=Common::getInstance()->getFooterCateAricle();

        //导航数据
        $navData=Common::getInstance()->getNavData();

        //网店信息文章
        $shopInfoArticle=Common::getInstance()->getShopInfoArticle();

        //获取全部商品分类信息
        $allCategoryInfo=Common::getInstance()->getCategoryByLevelTwo();

        $this->assign(compact('helpCateArticle','navData','config','shopInfoArticle','allCategoryInfo','is_login'));
    }


}
