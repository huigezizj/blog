@extends('admin.layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  导航管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>导航编辑</h3>
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
                <a href="{{url('admin/nav/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                <a href="{{url('admin/nav')}}"><i class="fa fa-recycle"></i>全部分类</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">

        <form action="{{url('admin/nav/'.$nav->nav_id)}}" method="post">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>

                <tr>
                    <th><i class="require">*</i>导航名称：</th>
                    <td>
                        <input type="text" name="nav_name" value="{{$nav->nav_name}}">

                    </td>
                </tr>
                <tr>
                    <th ><i class="require">*</i>url地址：</th>
                    <td>
                        <input type="text" class="lg" name="nav_url" value="{{$nav->nav_url}}">
                    </td>
                </tr>

                <tr>
                    <th>Tips：</th>
                    <td>
                        <input type="text"  name="nav_tips" value="{{$nav->nav_tips}}" size="30">

                    </td>
                </tr>

                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" class="sm" name="nav_order" value="{{$nav->nav_order}}">

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