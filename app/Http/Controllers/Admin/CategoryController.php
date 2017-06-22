<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;



class CategoryController extends CommonController
{
    //get category.index 分类列表
    public function index() {

        $category= (new Category)->tree();

        return view('admin.category.index')->with('data',$category);
    }

    //格式化关系树
    private function getTree($data) {
        foreach($data as $t){
            echo $t['cate_name'].'<br>';
            if(isset($t['son'])){
                $this->getTree($t['children']);
            }
        }

    }

    public function changeorder() {
        if ($input = Input::all()) {
            $cate = Category::find($input['cate_id']);
            $cate->cate_order =$input['cate_order'];
            $rs=$cate->update();
            if ($rs) {
                $data=[
                    'status'=>0,
                    'msg'=>'分类排序更新成功！',
                ];
            } else {
                $data=[
                    'status'=>1,
                    'msg'=>'分类排序更新失败！',
                ];

            }
        }
        return $data;
    }

    //get category.create 添加分类
    public function create() {
        $data=Category::where('cate_pid',0)->get();

        //或者用这汇总方式
        //return view('admin/category/add',compact('data'));
        return view('admin/category/add')->with('data',$data);
        
    }
    //post category.store 添加分类保存
    public function store() {
        $input=Input::except('_token');

        $rules=[
            'cate_name'=>'required',
        ];
        $msg=[
            'cate_name.required'=>'分类名称不能为空！'
        ];
        $validator=\Validator::make($input,$rules,$msg);
        if ($validator->passes()) {
            $rs= Category::create($input);
            if ($rs) {
                return redirect('admin/category');
            }else{
                return back()->with('errors','添加失败！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    //get category.show  显示单个单个分类
    public function show() {

    }
    //get category.edit 编辑分类
    public function edit($cate_id) {
        $cate=Category::find($cate_id);
        $data=Category::where('cate_pid',0)->get();
        return view('admin/category/edit',compact('cate','data'));
    }
    //put category.update 更新分类
    public function update($cate_id) {
        $input=Input::except(['_token','_method']);
        $rs=Category::where('cate_id',$cate_id)->update($input);

        if ($rs) {
            return redirect('admin/category');
        }else{

            return back()->with('errors','添加失败！');
        }

    }
    //delete category.destroy 删除单个分类
    public function destroy($cate_id) {
        $rs=Category::where('cate_id',$cate_id)->delete();
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
        if ($rs) {
            $data=[
                'status'=>0,
                'msg'=>'分类删除成功！'
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'分类删除失败！'
            ];

        }
        return $data;
    }

}

