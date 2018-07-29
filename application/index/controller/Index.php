<?php
namespace app\index\controller;

use app\admin\model\AlternateImg;
use app\admin\model\Brand;
use think\facade\Cache;
use think\facade\Request;

class Index extends Base
{
    /**
     * 前台首页
     */
    public function index()
    {
        //首页栏目推荐
        $recommendDatas=\app\index\service\Index::getInstance()->getRecommendData();

        //首页促销文章
        $saleArticle=\app\index\service\Index::getInstance()->getSaleArticle();

        //首页公告
        $noticeArticle=\app\index\service\Index::getInstance()->getNoticeArticle();

        //获取前18个品牌信息
        $brands=\app\index\service\Index::getInstance()->getBrands();

        //轮播图
        $alternateImgs=\app\index\service\Index::getInstance()->getAlternateImgs();

        $hb=$alternateImgs[0]->link_url;
        //首页推荐商品
        $indexGoods=\app\index\service\Index::getInstance()->getIndexGoods();
        $this->assign('show_category',1);
        $this->assign(compact('recommendDatas','indexGoods','saleArticle','noticeArticle','brands','alternateImgs'));
        return view();
    }


}
