<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
/**
 * 前台路由
 */




Route::get('/','index/index/index');
Route::get('/me/:id','index/user/show')->model('\app\admin\model\User');
Route::get('/hb','admin/attr/hb')->model('\app\admin\model\User');



Route::get('/cate','index/cate/index');
Route::get('/article/:id','index/article/index')->pattern(['id' => '\d+'])->model('\app\admin\model\Article');

Route::get('/register','index/account/register');
Route::post('/register','index/account/registerPost');
Route::get('/login','index/account/login');
Route::post('/login','index/account/loginPost');

Route::get('/logout','index/account/logout');
Route::get('/forget_password','index/account/forgetPassword');

Route::post('/password/:status','index/account/passwordMessage');


Route::post('/username/check','index/account/usernameCheck');
Route::post('/phone/check','index/account/phoneCheck');
Route::post('/phone/send','index/account/sendMessage');
Route::post('/phone/forget_check','index/account/forgetSendMessage');
Route::post('/phone/check_and_make_password','index/account/checkAndMakePasswordByPhone');
Route::post('/phone/check_code','index/account/messageCheckCode');


Route::post('/email/check','index/account/emailCheck');
Route::post('/email/check_code','index/account/emailCheckCode');
Route::post('/email/send','index/account/sendEmail');
Route::post('/email/forget_check','index/account/forgetSendEmail');


















/**
 *后台路由
 */

Route::get('clear_cache', 'admin/index/clearCache');
Route::get('admin/brand', 'admin/brand/index');
Route::get('admin/brand/:id', 'admin/brand/show')->pattern(['id' => '\d+'])->model('\app\admin\model\Brand');
Route::get('admin/brand/create', 'admin/brand/create');
Route::post('admin/brand', 'admin/brand/store');
Route::get('admin/brand/:id/edit', 'admin/brand/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\Brand');
Route::put('admin/brand/:id', 'admin/brand/update')->pattern(['id' => '\d+'])->model('\app\admin\model\Brand');
Route::delete('admin/brand/:id', 'admin/brand/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\Brand');


Route::get('admin/cate', 'admin/cate/index');
Route::get('admin/cate/create', 'admin/cate/create');
Route::post('admin/cate', 'admin/cate/store');
Route::get('admin/cate/:id/edit', 'admin/cate/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\Cate');
Route::put('admin/cate/:id', 'admin/cate/update')->pattern(['id' => '\d+'])->model('\app\admin\model\Cate');
Route::delete('admin/cate/:id', 'admin/cate/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\Cate');
Route::post('admin/cate/:id/sort', 'admin/cate/sort')->pattern(['id' => '\d+'])->model('\app\admin\model\Cate');


Route::get('admin/article', 'admin/article/index');
Route::get('admin/article/create', 'admin/article/create');
Route::post('admin/article', 'admin/article/store');
Route::get('admin/article/:id/edit', 'admin/article/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\Article');
Route::put('admin/article/:id', 'admin/article/update')->pattern(['id' => '\d+'])->model('\app\admin\model\Article');
Route::delete('admin/article/:id', 'admin/article/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\Article');
Route::get('admin/article/image', 'admin/article/image');
Route::delete('admin/article/image', 'admin/article/imageDelete');


Route::get('admin/link', 'admin/link/index');
Route::get('admin/link/create', 'admin/link/create');
Route::post('admin/link', 'admin/link/store');
Route::get('admin/link/:id/edit', 'admin/link/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\Link');
Route::put('admin/link/:id', 'admin/link/update')->pattern(['id' => '\d+'])->model('\app\admin\model\Link');
Route::delete('admin/link/:id', 'admin/link/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\Link');

Route::get('admin/conf', 'admin/conf/index');
Route::get('admin/conflist', 'admin/conf/conflist');
Route::put('admin/conflist', 'admin/conf/conflistUpdate');
Route::get('admin/conf/create', 'admin/conf/create');
Route::post('admin/conf', 'admin/conf/store');
Route::get('admin/conf/:id/edit', 'admin/conf/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\Conf');
Route::put('admin/conf/:id', 'admin/conf/update')->pattern(['id' => '\d+'])->model('\app\admin\model\Conf');
Route::delete('admin/conf/:id', 'admin/conf/delete')->pattern(['id' => '\d+'])->model('\app\admin\model\Conf');
Route::post('admin/conf/:id/sort', 'admin/conf/sort')->pattern(['id' => '\d+'])->model('\app\admin\model\Conf');


Route::get('admin/category', 'admin/category/index');
Route::get('admin/category/create', 'admin/category/create');
Route::post('admin/category', 'admin/category/store');
Route::get('admin/category/:id/edit', 'admin/category/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\Category');
Route::put('admin/category/:id', 'admin/category/update')->pattern(['id' => '\d+'])->model('\app\admin\model\Category');
Route::delete('admin/category/:id', 'admin/category/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\Category');
Route::post('admin/category/:id/sort', 'admin/category/sort')->pattern(['id' => '\d+'])->model('\app\admin\model\Category');



Route::get('admin/type', 'admin/type/index');
Route::get('admin/type/create', 'admin/type/create');
Route::post('admin/type', 'admin/type/store');
Route::get('admin/type/:id/edit', 'admin/type/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\Type');
Route::put('admin/type/:id', 'admin/type/update')->pattern(['id' => '\d+'])->model('\app\admin\model\Type');
Route::delete('admin/type/:id', 'admin/type/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\Type');

Route::get('admin/attr', 'admin/attr/index');
Route::get('admin/attr/create', 'admin/attr/create');
Route::post('admin/attr', 'admin/attr/store');
Route::get('admin/attr/:id/edit', 'admin/attr/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\Attr');
Route::put('admin/attr/:id', 'admin/attr/update')->pattern(['id' => '\d+'])->model('\app\admin\model\Attr');
Route::delete('admin/attr/:id', 'admin/attr/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\Attr');
Route::post('admin/attr/type', 'admin/attr/type');

Route::get('admin/memberLevel', 'admin/memberLevel/index');
Route::get('admin/memberLevel/create', 'admin/memberLevel/create');
Route::post('admin/memberLevel', 'admin/memberLevel/store');
Route::get('admin/memberLevel/:id/edit', 'admin/memberLevel/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\MemberLevel');
Route::put('admin/memberLevel/:id', 'admin/memberLevel/update')->pattern(['id' => '\d+'])->model('\app\admin\model\MemberLevel');
Route::delete('admin/memberLevel/:id', 'admin/memberLevel/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\MemberLevel');



Route::get('admin/goods', 'admin/goods/index');
Route::get('admin/goods/create', 'admin/goods/create');
Route::post('admin/goods', 'admin/goods/store');
Route::get('admin/goods/:id/edit', 'admin/goods/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\Goods');
Route::put('admin/goods/:id', 'admin/goods/update')->pattern(['id' => '\d+'])->model('\app\admin\model\Goods');
Route::delete('admin/goods/:id', 'admin/goods/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\Goods');
Route::get('admin/goods/product', 'admin/goods/product');
Route::post('admin/goods/product/:id', 'admin/goods/productChange')->pattern(['id' => '\d+']);
Route::delete('admin/goods/image/:id', 'admin/goods/deleteImage')->pattern(['id'=>'\d+'])->model('\app\admin\model\GoodsPhoto');


Route::delete('admin/goodsAttr/:id', 'admin/goodsAttr/destroy')->pattern(['id'=>'\d+'])->model('\app\admin\model\GoodsAttr');



Route::get('admin/nav', 'admin/nav/index');
Route::get('admin/nav/create', 'admin/nav/create');
Route::post('admin/nav', 'admin/nav/store');
Route::get('admin/nav/:id/edit', 'admin/nav/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\Nav');
Route::put('admin/nav/:id', 'admin/nav/update')->pattern(['id' => '\d+'])->model('\app\admin\model\Nav');
Route::delete('admin/nav/:id', 'admin/nav/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\Nav');
Route::post('admin/nav/:id/sort', 'admin/nav/sort')->pattern(['id' => '\d+'])->model('\app\admin\model\Nav');

Route::get('admin/recpos', 'admin/recpos/index');
Route::get('admin/recpos/create', 'admin/recpos/create');
Route::post('admin/recpos', 'admin/recpos/store');
Route::get('admin/recpos/:id/edit', 'admin/recpos/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\Recpos');
Route::put('admin/recpos/:id', 'admin/recpos/update')->pattern(['id' => '\d+'])->model('\app\admin\model\Recpos');
Route::delete('admin/recpos/:id', 'admin/recpos/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\Recpos');


Route::get('admin/category_words', 'admin/category_words/index');
Route::get('admin/category_words/create', 'admin/category_words/create');
Route::post('admin/category_words', 'admin/category_words/store');
Route::get('admin/category_words/:id/edit', 'admin/category_words/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\CategoryWords');
Route::put('admin/category_words/:id', 'admin/category_words/update')->pattern(['id' => '\d+'])->model('\app\admin\model\CategoryWords');
Route::delete('admin/category_words/:id', 'admin/category_words/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\CategoryWords');

Route::get('admin/category_brands', 'admin/category_brands/index');
Route::get('admin/category_brands/create', 'admin/category_brands/create');
Route::post('admin/category_brands', 'admin/category_brands/store');
Route::get('admin/category_brands/:id/edit', 'admin/category_brands/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\CategoryBrands');
Route::put('admin/category_brands/:id', 'admin/category_brands/update')->pattern(['id' => '\d+'])->model('\app\admin\model\CategoryBrands');
Route::delete('admin/category_brands/:id', 'admin/category_brands/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\CategoryBrands');

Route::get('admin/category_ad', 'admin/category_ad/index');
Route::get('admin/category_ad/create', 'admin/category_ad/create');
Route::post('admin/category_ad', 'admin/category_ad/store');
Route::get('admin/category_ad/:id/edit', 'admin/category_ad/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\CategoryAd');
Route::put('admin/category_ad/:id', 'admin/category_ad/update')->pattern(['id' => '\d+'])->model('\app\admin\model\CategoryAd');
Route::delete('admin/category_ad/:id', 'admin/category_ad/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\CategoryAd');

Route::get('admin/alternate_img', 'admin/alternate_img/index');
Route::get('admin/alternate_img/create', 'admin/alternate_img/create');
Route::post('admin/alternate_img', 'admin/alternate_img/store');
Route::get('admin/alternate_img/:id/edit', 'admin/alternate_img/edit')->pattern(['id' => '\d+'])->model('\app\admin\model\AlternateImg');
Route::put('admin/alternate_img/:id', 'admin/alternate_img/update')->pattern(['id' => '\d+'])->model('\app\admin\model\AlternateImg');
Route::delete('admin/alternate_img/:id', 'admin/alternate_img/destroy')->pattern(['id' => '\d+'])->model('\app\admin\model\AlternateImg');
Route::post('admin/alternate_img/:id/sort', 'admin/alternate_img/sort')->pattern(['id' => '\d+'])->model('\app\admin\model\AlternateImg');





