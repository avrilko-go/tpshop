<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/30
 * Time: 11:12
 */

namespace app\index\service;


use app\admin\model\AlternateImg;
use app\admin\model\Brand;
use app\admin\model\Cate;
use app\admin\model\Category;
use app\admin\model\CategoryAd;
use app\admin\model\Goods;
use app\admin\model\RecItem;
use app\lib\Utils;
use think\facade\Cache;

class Index
{
    private static $obj;

    private $cache;

    private $cacheTime;

    public static function getInstance()
    {
        if(self::$obj){
            return self::$obj;
        }else{
            return new self();
        }
    }

    public function __construct()
    {
        $config=Cache::get('config');
        if($config){
            $this->cache=$config['cache'];
            $this->cacheTime=$config['cache_time'];
        }
    }


    //获取首页推荐数据
    public function getRecommendData()
    {

        if(Cache::get('recommendDatas')){
            $recommendDatas=Cache::get('recommendDatas');
        }else{
            //获取所有首页分类推荐的id
            $data=RecItem::with(['category'=>function($query){
                $query->where('pid',0);
            }])->where(['recpos_id'=>5,'value_type'=>2])->column('value_id');
            $data=implode(',',$data);

            //查询所有首页分类的具体分类信息
            $catogories=Category::with('child')->with('categoryBrands')->with('categoryAd')->where('id','in',$data)->select();
            foreach ($catogories as $k=>$v){
                //获取一级栏目下面所有的精品推荐商品
                $v['recommenLevel1']=$this->getSonData($v['id'],7);
                foreach ($v['child'] as $k1=>$v1){
                    //获取二级栏目下面的所有精品推荐商品
                    $v1['recommenLevel2']=$this->getSonData($v1['id'],7);
                    $v['child'][$k1]=$v1;
                }

                //获取所有品牌关联信息
                foreach ($v['categoryBrands'] as $k1=>$v1){
                    $child=[];
                    $brands=explode(',',$v1['brands_id']);
                    foreach ($brands as $k2=>$v2){
                        $data=Brand::where('id',$v2)->find();
                        array_push($child,$data);
                    }
                    $v1['child']=$child;
                    $v['category_brands'][$k1]=$v1;
                }

                $arr=[];

                foreach ($v['categoryAd'] as $k1=>$v1){
                    $arr[$v1['position']][]=$v1;
                }

                $v['categoryLeft']=$arr;

                $catogories[$k]=$v;
            }
            $recommendDatas=$catogories;
            if($this->cache=='是'){
                Cache::set('recommendDatas',$recommendDatas,$this->cacheTime);
            }
        }
        return $recommendDatas;
    }

    //获取促销文章
    public function getSaleArticle()
    {
        if(Cache::get('saleArticle')){
            $saleArticle=Cache::get('saleArticle');
        }else{
            $saleArticle=\app\admin\model\Article::where('cate_id',26)->order('id','desc')->limit(3)->select();
            if($this->cache=='是'){
                Cache::set('saleArticle',$saleArticle,$this->cacheTime);
            }
        }
        return $saleArticle;
    }

    //获取公告文章
    public function getNoticeArticle()
    {
        if(Cache::get('noticeArticle')){
            $noticeArticle=Cache::get('noticeArticle');
        }else{
            $noticeArticle=\app\admin\model\Article::where('cate_id',20)->order('id','desc')->limit(3)->select();
            if($this->cache=='是'){
                Cache::set('noticeArticle',$noticeArticle,$this->cacheTime);
            }
        }
        return $noticeArticle;
    }

    //获取前18个品牌信息
    public function getBrands()
    {
        if(Cache::get('brands')){
            $brands=Cache::get('brands');
        }else{
            $brands=Brand::limit(18)->select();
            if($this->cache=='是'){
                Cache::set('brands',$brands,$this->cacheTime);
            }
        }
        return $brands;
    }

    //获取轮播图信息
    public function getAlternateImgs()
    {
        if(Cache::get('alternateImgs')){
            $alternateImgs=Cache::get('alternateImgs');
        }else{
            $alternateImgs=AlternateImg::order('sort','desc')->limit(3)->select();
            if($this->cache=='是'){
                Cache::set('alternateImgs',$alternateImgs,$this->cacheTime);
            }
        }
        return $alternateImgs;
    }


    //获取首页推荐商品
    public function getIndexGoods()
    {
        if(Cache::get('indexGoods')){
            $indexGoods=Cache::get('indexGoods');
        }else{
            $indexGoods=RecItem::with('goods')->where(['recpos_id'=>8,'value_type'=>1])->select();
            if($this->cache=='是'){
                Cache::set('indexGoods',$indexGoods,$this->cacheTime);
            }
        }
        return $indexGoods;

    }


    //根据商品推荐类型不同获取分类下所有子分类的商品信息
    private function getSonData($id,$recpos_id)
    {
        $allCategory=Category::all();

        $categoryIds=Utils::getSon($id,$allCategory);
        array_push($categoryIds,$id);

        $categoryIds=implode(',',$categoryIds);

        $goodsId=Goods::where('category_id','in',$categoryIds)->column('id');

        $goodsId=implode(',',$goodsId);

        $goodsData=RecItem::with(['goods'=>function($query) use($goodsId) {
            $query->where('id','in',$goodsId);
        }])->where(['recpos_id'=>$recpos_id,'value_type'=>1])->select();
        return $goodsData;
    }


}