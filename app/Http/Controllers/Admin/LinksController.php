<?php

namespace App\Http\Controllers\admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\DocBlock\Tags\Link;

class LinksController extends CommonController
{
    public function index() {

        $data=Links::orderBy('link_order','asc')
            ->paginate(10);

        return view('admin.links.index',compact('data'));

    }

    public function changeorder() {
        if ($input = Input::all()) {

            $link = Links::find($input['link_id']);
            $link->link_order =$input['link_order'];
            $rs=$link->update();
            if ($rs) {
                $data=[
                    'status'=>0,
                    'msg'=>'链接排序更新成功！',
                ];
            } else {
                $data=[
                    'status'=>1,
                    'msg'=>'链接排序更新失败！',
                ];
            }
        }
        return $data;
    }

    public function create() {
        return view('admin.links.add');
    }

    public function store() {
        $input = Input::except('_token');
        $rules=[
            'link_name'=>'required',
            'link_url'=>'required',
        ];
        $msg=[
            'link_name.required'=>'链接名称不能为空！',
            'link_url.required'=>'链接url不能为空！',
        ];
        $validator=\Validator::make($input,$rules,$msg);
        if ($validator->passes()) {
            $rs=Links::create($input);
            if ($rs) {
                return redirect('admin/links');
            } else {
                return back()->with('errors', '写入失败');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    //get link.edit 编辑链接
    public function edit($link_id) {
        $link=Links::find($link_id);
        return view('admin/links/edit',compact('link'));
    }
    //put link.update 更新链接
    public function update($link_id) {
        $input=Input::except(['_token','_method']);

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
            $rs=Links::where('link_id',$link_id)->update($input);
            if ($rs) {
                return redirect('admin/links');
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
    public function destroy($link_id) {
        $rs=Links::where('link_id',$link_id)->delete();
        if ($rs) {
            $data=[
                'status'=>0,
                'msg'=>'链接删除成功！'
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'链接删除失败！'
            ];

        }
        return $data;
    }

    public function multDelete() {
        $ids=Input::get('ids');
        $idarr=explode(',',$ids);
        $rs=Links::whereIn('link_id', $idarr)->delete();

        if ($rs) {
            $data=[
                'status'=>0,
                'msg'=>'链接批量删除成功！'
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'链接批量删除失败！'
            ];

        }
        return $data;
    }

    public function search() {
        $keywords=Input::get('keywords');
        $data=Links::where('link_name','like','%'.$keywords.'%')
            ->orWhere('link_title','like','%'.$keywords.'%')
            ->orWhere('link_url','like','%'.$keywords.'%')
            ->paginate(10);
//        $data->setPath('admin/search');
        return view('admin.links.index',compact('data','keywords'));
    }

}
