<?php

namespace App\Http\Controllers\admin;

use App\Http\Model\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\DocBlock\Tags\Link;

class NavController extends CommonController
{
    public function index() {

        $data=Nav::orderBy('nav_order','asc')
            ->paginate(10);

        return view('admin.nav.index',compact('data'));

    }

    public function changeorder() {
        if ($input = Input::all()) {

            $nav = Nav::find($input['nav_id']);
            $nav->nav_order =$input['nav_order'];
            $rs=$nav->update();
            if ($rs) {
                $data=[
                    'status'=>0,
                    'msg'=>'链接排序更新成功！',
                ];
            } else {
                $data=[
                    'status'=>0,
                    'msg'=>'链接排序更新失败！',
                ];
            }
        }
        return $data;
    }

    public function create() {
        return view('admin.nav.add');
    }

    public function store() {
        $input = Input::except('_token');
        $rules=[
            'nav_name'=>'required',
            'nav_url'=>'required',
        ];
        $msg=[
            'nav_name.required'=>'导航名称不能为空！',
            'nav_url.required'=>'url地址不能为空！',
        ];
        $validator=\Validator::make($input,$rules,$msg);
        if ($validator->passes()) {
            $rs=Nav::create($input);
            if ($rs) {
                return redirect('admin/nav');
            } else {
                return back()->with('errors', '写入失败');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    //get nav.edit 编辑链接
    public function edit($nav_id) {
        $nav=Nav::find($nav_id);
        return view('admin/nav/edit',compact('nav'));
    }
    //put nav.update 更新链接
    public function update($nav_id) {
        $input=Input::except('_token','_method');
        $rules=[
            'nav_name'=>'required',
            'nav_url'=>'required',
        ];
        $msg=[
            'nav_name.required'=>'导航名称不能为空！',
            'nav_url.required'=>'url地址不能为空！'
        ];
        $validator=\Validator::make($input,$rules,$msg);

        if ($validator->passes()) {
            $rs=Nav::where('nav_id',$nav_id)->update($input);
            if ($rs) {
                return redirect('admin/nav');
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
    public function destroy($nav_id) {
        $rs=Nav::where('nav_id',$nav_id)->delete();
        if ($rs) {
            $data=[
                'status'=>0,
                'msg'=>'链接删除成功！'
            ];
        }else{
            $data=[
                'status'=>0,
                'msg'=>'链接删除失败！'
            ];

        }
        return $data;
    }

}
