<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['namespace'=>'Home','middleware'=>['visitor'] ], function () {
    Route::get('/', 'IndexController@index');
    Route::get('/cate/{cate_id}','IndexController@cate');
    Route::get('/article/{art_id}','IndexController@article');

    Route::any('/getWether','IndexController@getWether');
});


Route::any('admin/login','Admin\LoginController@login');
Route::get('admin/code','Admin\LoginController@code');
//Route::get('admin/getcode','Admin\LoginController@getcode');
//Route::any('admin/crypt','Admin\LoginController@crypt');


//后台
Route::group(['middleware'=>['admin.login'],'prefix'=>'admin','namespace'=>'Admin' ],function(){

    Route::get('/','IndexController@index');
    Route::get('info','IndexController@info');
    Route::get('quit','LoginController@quit');
    Route::any('pass','IndexController@pass');//修改密码


    Route::post('cate/changeorder','CategoryController@changeOrder');
    Route::post('links/changeorder','LinksController@changeOrder');
    Route::post('nav/changeorder','NavController@changeOrder');
    Route::post('config/changeorder','ConfigController@changeOrder');

    Route::post('config/changeContent','ConfigController@changeContent');



    //分类
    Route::resource('category','CategoryController', ['only'=> ['index','create','store','destroy','update','edit']]);
    //文章
    Route::resource('article','ArticleController', ['only'=> ['index','create','store','destroy','update','edit']]);
    Route::post('article/multDelete','ArticleController@multDelete');
    Route::any('article/search','ArticleController@search');

    //友链
    Route::resource('links','LinksController', ['only'=> ['index','create','store','destroy','update','edit']]);
    Route::post('links/multDelete','LinksController@multDelete');
    Route::any('links/search','LinksController@search');

    //导航
    Route::resource('nav','NavController');

//    Route::resource('config','ConfigController');//配置
    Route::resource('config', 'ConfigController', ['only'=> ['index','create','store','destroy','update','edit']]);
    //上传
    Route::any('upload','CommonController@upload');


    //上传
    Route::any('config/putfile','ConfigController@putFile');


});


