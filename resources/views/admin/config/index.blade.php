@extends('admin.layouts.admin')
@section('content')
    <!--面包屑配置 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 配置管理
    </div>
    <!--面包屑配置 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">

        <form action="" method="post">
            <table class="search_tab">
                <tr>

                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>配置列表</h3>
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
            <!--快捷配置 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置</a>
                </div>
            </div>
            <!--快捷配置 结束-->
        </div>
    </form>
        <div class="result_wrap">
            <div class="result_content">
                <form action="{{url('admin/config/changeContent')}}" method="post">
                    {{csrf_field()}}
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%"><input type="checkbox" name=""></th>
                        <th  width="5%" class="tc">排序</th>
                        <th  width="5%" class="tc">ID</th>
                        <th>配置标题</th>
                        <th >配置名称</th>
                        <th >内容</th>
                        <th width="7%">操作</th>
                    </tr>


                    @foreach($data as $v)
                    <tr>
                        <td class="tc"><input type="checkbox" name="id[]" value="{{$v->config_id}}"></td>

                        <td class="tc"><input type="text" name="ord[]" onchange="changeOrder({{$v['config_id']}},this);" value="{{$v->config_order}}"></td>
                        <td class="tc">{{$v->config_id}}</td>
                        <td>{{$v->config_title}}</td>
                        <td>{{$v->config_name}}</td>
                        <td onchange="changeContent()">
                            <input type="hidden" name="config_id[]" value="{{$v->config_id}}">
                            {!! $v->_html !!}
                        </td>
                        <td>
                            <a href="{{url('admin/config/'.$v->config_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delArt({{$v->config_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach


                </table>




                <div class="page_list">
                    {{$data->links()}} <ul><span class="rows" style="    line-height: 30px;"><h5>Page {{$data->currentPage() }} of {{$data->lastPage()}}</h5></span></ul>
                </div>

                    <div class="btn_group">
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回" >
                    </div>
            </div>
        </div>

    </form>

    <!--搜索结果页面 列表 结束-->
    <script>
        function delArt(config_id){
            //询问框
            layer.confirm('确定要删除该配置吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post('{{url('admin/config/')}}/'+config_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data) {
                    if (data.status==0) {
                        layer.msg(data.msg, {icon: 6});
                        location.href=location.href;
                    }else{
                        layer.msg(data.msg, {icon: 5});
                    }
                });

            }, function(){
//                layer.msg('也可以这样', {
//                    time: 20000, //20s后自动关闭
//                    btn: ['明白了', '知道了']
//                });
            });
        }
        function changeOrder(config_id,obj) {
            var config_order=$(obj).val();

            $.post('{{url('admin/config/changeorder')}}',{'_token':'{{csrf_token()}}',config_id:config_id,config_order:config_order},function (data) {
                if (data.status==0) {
                    layer.msg(data.msg);
                    location.reload();
                }else{
                    layer.msg(data.msg,{icon:5});
                }
            })
        }


    </script>

@endsection