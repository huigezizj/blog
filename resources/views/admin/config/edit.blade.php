@extends('admin.layouts.admin')
@section('content')

    <!--面包屑配置 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  配置管理
    </div>
    <!--面包屑配置 结束-->

	<!--结果集标题与配置组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>配置编辑</h3>

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
                <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部分类</a>
            </div>
        </div>
    </div>
    <!--结果集标题与配置组件 结束-->
    
    <div class="result_wrap">

        <form action="{{url('admin/config/'.$config->config_id)}}" method="post">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <table class="add_tab">
                    <tbody>

                    <tr>
                        <th><i class="require">*</i>配置标题：</th>
                        <td>
                            <input type="text" name="config_title" value="{{$config->config_title}}">
                            {{--<span><i class="fa fa-exclamation-circle yellow"></i>必填</span>--}}
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>配置名称：</th>
                        <td>
                            <input type="text" name="config_name" value="{{$config->config_name}}">
                            {{--<span><i class="fa fa-exclamation-circle yellow"></i>必填</span>--}}
                        </td>
                    </tr>
                    <tr >
                        <th>类型：</th>
                        <td>
                            <input type="radio" name="field_type" value="input" id="r1" @if($config->field_type=='input') checked @endif><label for="r1">input</label>
                            <input type="radio" name="field_type" value="textarea"id="r2"  @if($config->field_type=='textarea') checked @endif><label for="r2">textarea</label>
                            <input type="radio" name="field_type" value="radio"id="r3"  @if($config->field_type=='radio') checked @endif><label for="r3">radio</label>
                            {{--<span><i class="fa fa-exclamation-circle yellow"></i>必填</span>--}}
                        </td>
                    </tr>
                    <tr  @if($config->field_type!='radio') style="display: none" @endif >
                        <th >类型值：</th>
                        <td>
                            <input type="text" class="lg" name="field_value"  value="{{$config->field_value}}">
                            <p><span><i class="fa fa-exclamation-circle yellow">格式：开启|1,关闭|0 </i></span></p>
                        </td>


                    </tr>

                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="config_order"  value="{{$config->config_order}}">

                        </td>
                    </tr>
                    <tr>
                        <th>说明：</th>
                        <td>
                            <textarea name="config_tips" id="" cols="30" rows="10">{{$config->config_tips}}</textarea>

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
            </table>
        </form>
    </div>
    <script>
        $(function () {
            $('#r1,#r2').click(function () {
                $('#r3').parent().parent().next().attr('style','display:none');
            });
            $('#r3').click(function () {
                $('#r3').parent().parent().next().removeAttr('style');
            });
        });
    </script>
@endsection