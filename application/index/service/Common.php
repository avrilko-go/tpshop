<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/30
 * Time: 16:23
 */

namespace app\index\service;


use app\admin\model\Article;
use app\admin\model\Brand;
use app\admin\model\Cate;
use app\admin\model\Category;
use app\admin\model\Conf;
use app\admin\model\Nav;
use app\admin\model\User;
use app\lib\Utils;
use think\facade\Cache;
use think\facade\Cookie;
use think\facade\Session;

class Common
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

    //获取网站配置信息
    public static function getConfig()
    {
        if(!Cache::get('config')){
            $__config=Conf::all();
            $config=[];
            foreach ($__config as $k=>$v){
                $config[$v['ename']]=$v['value'];
            }
            Cache::set('config',$config,$config['cache_time']);
            return $config;
        }else{
            return Cache::get('config');
        }
    }

    //判断用户登录状态
    public static function checkLogin()
    {
        if(Session::get('user')){
            return true;
        }
        $username=Cookie::get('username');
        $password=Cookie::get('password');
        if($username && $password){
            $user=User::where(['username'=>Utils::decrypt($username),'password'=>Utils::decrypt($password)])->find();
            if($user){
                Session::set('user',$user);
                return true;
            }else{
                return false;
            }
        }
        return false;
    }


    //获取底部分类信息
    public function getFooterCateAricle()
    {
        if(Cache::get('helpCateArticle')){
            $helpCateArticle=Cache::get('helpCateArticle');
        }else{
            $helpCateArticle=Cate::with('article')->where('cate_type',3)->select();
            if($this->cache=='是'){
                Cache::set('helpCateArticle',$helpCateArticle,$this->cacheTime);
            }
        }
        return $helpCateArticle;
    }

    //获取导航信息
    public function getNavData()
    {
        if(Cache::get('navData')){
            $data=Cache::get('navData');
        }else{
            $__data=Nav::all();
            $data=[];
            foreach ($__data as $k=>$v){
                $data[$v['pos']][]=$v;
            }
            if($this->cache=='是'){
                Cache::set('navData',$data,$this->cacheTime);
            }
        }
        return $data;
    }



    //网店信息文章
    public function getShopInfoArticle()
    {
        if(Cache::get('shopInfoArticle')){
            $shopInfoArticle=Cache::get('shopInfoArticle');
        }else{
            $shopInfoArticle=Article::where('cate_id',3)->select();
            if($this->cache=='是'){
                Cache::set('shopInfoArticle',$shopInfoArticle,$this->cacheTime);
            }
        }
        return $shopInfoArticle;
    }

    //获取首页全部商品分类信息
    public function getCategoryByLevelTwo()
    {
        if(Cache::get('allCategoryInfo')){
            $allCategoryInfo=Cache::get('allCategoryInfo');
        }else{
            $result=Category::with('child.child')->with('categoryWords')->with('categoryBrands')->where('pid',0)->select();
            foreach ($result as $k=>$v){
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
                $result[$k]=$v;
            }
            $allCategoryInfo=$result;
            if($this->cache=='是'){
                Cache::set('allCategoryInfo',$allCategoryInfo,$this->cacheTime);
            }
        }
        return $allCategoryInfo;
    }
}