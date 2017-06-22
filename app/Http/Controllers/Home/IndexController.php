<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\http\model\Links;
use App\http\model\Nav;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use Zhuzhichao\IpLocationZh\Ip;


class IndexController extends CommonController
{
    public function index() {

        //后台推荐的6篇文章
        $ids=config('web.web_head_article');
        $ids=explode(',',$ids);
        $promote_art=Article::whereIn('art_id',$ids)->limit(7)->get();

        //图文列表5
        $data=Article::orderBy('art_id','desc')->paginate(6);





        //友情链接
        $links=Links::orderBy('link_order','asc')->get();

        //热门分类
        //todo

        //热门标签
        //todo



        return view('home/'.config('web.web_style').'/index',compact('promote_art','data','hot','links'));
    }

    public function cate($cate_id) {
        //图文列表5
        $data = Article::leftJoin('Category', 'category.cate_id', '=', 'article.cate_id')
                ->where('category.cate_id', $cate_id)
                ->orWhere('category.cate_pid', $cate_id)
                ->orderBy('article.art_id', 'desc')
                ->paginate(5);


        $cate=Category::find($cate_id);
        $sub_cate=Category::where('cate_pid',$cate_id)->get();
        $meta['title']=$cate->cate_name;
        $meta['keywords']=$cate->cate_keywords;
        $meta['description']=$cate->cate_description;

        if ($cate->cate_pid>0) {
            $meta['title']=$data[0]->cate_name;
            $meta['keywords']=$data[0]->cate_keywords;
            $meta['description']=$data[0]->cate_description;
            $sub_cate=Category::where('cate_pid',$cate->cate_pid)->get();
            $cate=Category::find($cate->cate_pid);

        }


        return view('home/'.config('web.web_style').'/list',compact('data','cate','sub_cate','meta'));
    }

    public function article($art_id) {
        static $arts=[];
        $aid = \Cookie('1', 1, 10);



        //获取cookie中的aid数组
        $art_ids_cookie=Cookie::get('aid');
        $arts=unserialize($art_ids_cookie);

        //如果art_id存在，不做访问次数处理
        if (is_array($arts)&&in_array($art_id,$arts)) {

        }else{

            //访问+1
            Article::where('art_id','=',$art_id)->increment('art_view');
            //art_id序列化 存入cookie,10分钟
            if ($arts) {
                array_push($arts,$art_id);
            }else{
                $arts[]=$art_id;
            }


            $art_ids=serialize($arts);
            $aid = \Cookie('aid', $art_ids, 10);
        }
        //访客历史



        $art=Article::find($art_id);
        $cate_id=$art->cate_id;

        $cate=Category::find($cate_id);
        $sub_cate=Category::where('cate_pid',$cate_id)->get();

        if ($cate->cate_pid>0) {
            $sub_cate=Category::where('cate_pid',$cate->cate_pid)->get();
            $cate=Category::find($cate->cate_pid);
        }

        $art['pre']=Article::where('art_id','<',$art->art_id)->where('cate_id','=',$cate->cate_id)->orderBy('art_id','desc')->first();
        $art['next']=Article::where('art_id','>',$art->art_id)->where('cate_id','=',$cate->cate_id)->orderBy('art_id','asc')->first();

        //相关文章
        $data=Article::where('cate_id','=',$cate->cate_id)->orderBy('art_id','desc')->take(6)->get();

//        Category::orderBy('cat_order')->
        return response()
            ->view('home/'.config('web.web_style').'/article',compact('art','sub_cate','cate','art','data'))
            ->cookie($aid);
    }

    public function getWether() {

        $wether=file_get_contents('http://i.tianqi.com/index.php?c=code&id=55');
        return view('home/'.config('web.web_style').'/layouts/wether')->with('wether',$wether);
//        return Cookie::get('visitor');

    }
}
