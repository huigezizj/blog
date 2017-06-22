@extends('admin.layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  链接管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>链接编辑</h3>
            @if(count($errors))
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>{{$errors}}</p>
                        @endforeach
                    @else
                        <p>{{$errors}}</p>
                    @endif

                </div>
            @endif

        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>全部分类</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">

        <form action="{{url('admin/links/'.$link->link_id)}}" method="post">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>

                <tr>
                    <th><i class="require">*</i>链接名称：</th>
                    <td>
                        <input type="text" name="link_name" value="{{$link->link_name}}">

                    </td>
                </tr>
                <tr>
                    <th ><i class="require">*</i>url地址：</th>
                    <td>
                        <input type="text" class="lg" name="link_url" value="{{$link->link_url}}">
                    </td>
                </tr>
                <tr>
                    <th>链接标题：</th>
                    <td>
                        <input type="text" class="lg" name="link_title" value="{{$link->link_title}}">
                        <p>标题可以写30个字</p>
                    </td>
                </tr>



                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" class="sm" name="link_order" value="{{$link->link_order}}">

                    </td>
                </tr>

                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>

@endsection