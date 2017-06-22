<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\http\model\Nav;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;


use Illuminate\Support\Facades\View;


class CommonController extends Controller
{
    public function __construct(Request $request) {
        //导航
        $nav=Nav::all();

        //点击量最高的5篇文章
        $cate_id=$request->cate_id;
        $hot=isset($cate_id)?Article::where('cate_id',$cate_id)->orderBy('art_view','desc')->take(5)->get():Article::orderBy('art_view','desc')->skip(5)->take(5)->get();


        //最新的8篇文章
        $new=isset($cate_id)?Article::where('cate_id',$cate_id)->orderBy('art_addtime','desc')->skip(5)->take(8)->get():Article::orderBy('art_addtime','desc')->skip(5)->take(8)->get();




        View::share('nav',$nav);
        View::share('hot',$hot);
        View::share('new',$new);

    }
    static public function getIp(){
        $onlineip='';
        if(getenv('HTTP_CLIENT_IP')&&strcasecmp(getenv('HTTP_CLIENT_IP'),'unknown')){
            $onlineip=getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR')&&strcasecmp(getenv('HTTP_X_FORWARDED_FOR'),'unknown')){
            $onlineip=getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR')&&strcasecmp(getenv('REMOTE_ADDR'),'unknown')){
            $onlineip=getenv('REMOTE_ADDR');
        } elseif(isset($_SERVER['REMOTE_ADDR'])&&$_SERVER['REMOTE_ADDR']&&strcasecmp($_SERVER['REMOTE_ADDR'],'unknown')){
            $onlineip=$_SERVER['REMOTE_ADDR'];
        }
        return $onlineip;
    }
}
