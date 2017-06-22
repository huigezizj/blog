<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ArticleController extends CommonController
{
    //文章列表
    public function index() {
        $cate=(new Category)->tree2();
        $data=Article::leftjoin('category','category.cate_id','=','article.cate_id')
            ->orderBy('art_id')
            ->paginate(10);
        return view('admin.article.index',compact('data','cate'));
    }

    //添加文章
    public function create() {
        $data=(new Category)->tree2();
        return view('admin.article.add',compact('data'));
    }
    //保存提交文章
    public function store() {
        $input=Input::except('_token');
        $rules=[
            'art_title'=>'required',
            'art_content'=>'required',
        ];
        $msg=[
            'art_title.required'=>'文章标题不能为空！',
            'art_content.required'=>'文章内容不能为空！'
        ];
        $validator=\Validator::make($input,$rules,$msg);

        if ($validator->passes()) {
            $input['art_addtime']=time();
            $rs=Article::create($input);
            if ($rs) {
                return redirect('admin/article');
            }else{
                return back()->with('errors','添加失败！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //get Article.edit 编辑文章
    public function edit($art_id) {
        $art=Article::find($art_id);
        $data=(new Category)->tree2();

        return view('admin/article/edit',compact('art','data'));
    }

    public function update($art_id) {
        $input=Input::except('_token','_method');
        $rules=[
            'art_title'=>'required',
            'art_content'=>'required',
        ];
        $msg=[
            'art_title.required'=>'文章标题不能为空！',
            'art_content.required'=>'文章内容不能为空！'
        ];
        $validator=\Validator::make($input,$rules,$msg);

        if ($validator->passes()) {
            $input['art_edittime']=time();
            $rs=Article::where('art_id',$art_id)->update($input);
            if ($rs) {
                return redirect('admin/article');
            }else{
                return back()->with('errors','添加失败！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * 删除单个文章
     * @param $cate_id
     * @return array
     */
    public function destroy($art_id) {
        $rs=Article::where('art_id',$art_id)->delete();
        if ($rs) {
            $data=[
                'status'=>0,
                'msg'=>'文章删除成功！'
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'文章删除失败！'
            ];

        }
        return $data;
    }
    public function multDelete() {
        $ids=Input::get('ids');
        $idarr=explode(',',$ids);
        $rs=Article::whereIn('art_id', $idarr)->delete();

        if ($rs) {
            $data=[
                'status'=>0,
                'msg'=>'文章批量删除成功！'
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'文章批量删除失败！'
            ];

        }
        return $data;
    }

    public function search() {
        $cate=(new Category)->tree2();
        $cate_id=Input::get('cate_id');

        $keywords=is_null(Input::get('keywords'))?'':Input::get('keywords');

        $data=Article::leftjoin('category','category.cate_id','=','article.cate_id')
            ->orderBy('article.art_id')
            ->where('article.cate_id',$cate_id);

        //闭包生成括号
        $keywords && $data=$data->where(function($query) use($keywords){
            $query->orwhere('article.art_tag','like','%'.$keywords.'%')
                ->orWhere('article.art_editor','like','%'.$keywords.'%')
                ->orWhere('article.art_description','like','%'.$keywords.'%');

        });

        $data=$data->paginate(10);






//        $data->setPath('admin/search');
        return view('admin.article.index',compact('data','keywords','cate'));
    }

}
