@extends('admin.layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>  &raquo; 分类管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>
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
                <h3>分类管理</h3>



            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                    <a href="{{url('admin/category')}}"><i class="fa fa-recycle"></i>全部分类</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%"><input type="checkbox" name=""></th>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>分类名称</th>
                        <th>标题</th>
                        <th width="5%">查看次数</th>

                        <th width="10%">操作</th>
                    </tr>
                    @foreach($data as $k=>$v)

                    <tr >
                        <td class="tc"><input type="checkbox" name="id[]" value="{{$v['cate_id']}}"></td>
                        <td class="tc">
                            <input type="text" name="ord[]" onchange="changeOrder({{$v['cate_id']}},this);" value="{{$v['cate_order']}}">
                        </td>
                        <td class="tc">{{$v['cate_id']}}</td>
                        <td onclick="sstore({{$v['cate_id']}});"  data-type="f{{$v['cate_id']}}">
                            <a href="#">{{$v['cate_name']}}</a>
                        </td>
                        <td>{{$v['cate_title']}}</td>
                        <td>{{$v['cate_view']}}</td>

                        <td>
                            <a href="{{url("admin/category/$v[cate_id]/edit")}}">修改</a>
                            <a href="javascript:;" onclick="delCate({{$v['cate_id']}});">删除</a>
                        </td>
                    </tr>
                        @if($v['children'])
                            @foreach($v['children'] as $kk=>$vv)
                            <tr data-type="{{$v['cate_id']}}">
                                <td class="tc"><input type="checkbox" name="id[]" value="{{$vv['cate_id']}}"></td>
                                <td class="tc">
                                    <input type="text" name="ord[]" onchange="changeOrder({{$vv['cate_id']}},this);" value="{{$vv['cate_order']}}">
                                </td>
                                <td class="tc">{{$vv['cate_id']}}</td>
                                <td>
                                    <a href="#"> 一{{$vv['cate_name']}}</a>
                                </td>
                                <td>{{$vv['cate_title']}}</td>
                                <td>{{$vv['cate_view']}}</td>

                                <td>
                                    <a href="{{url("admin/category/$vv[cate_id]/edit")}}">修改</a>
                                    <a href="javascript:;" onclick="delCate({{$vv['cate_id']}});">删除</a>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    @endforeach


                </table>
                <input type="hidden" value="0" id="fflag">




            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>

        function changeOrder(cate_id,obj) {
            var cate_order=$(obj).val();

            $.post('{{url('admin/cate/changeorder')}}',{'_token':'{{csrf_token()}}',cate_id:cate_id,cate_order:cate_order},function (data) {
                if (data.status==0) {
                    layer.msg(data.msg);
                }else{
                    layer.msg(data.msg,{icon:5});
                }
            })
        }

        function sstore(cateid) {

//                        $('tr[data-type="'+cateid+'"]').slideUp(1000);

            if ($("#fflag").val()==0) {

                $('tr[data-type="'+cateid+'"]').slideUp(1);
                $("#fflag").val(1);
                $('td[data-type="f'+cateid+'"]').find('span').remove()
                $('td[data-type="f'+cateid+'"]').append('<span>▲</span>');
                return false;
            }
            $('tr[data-type="'+cateid+'"]').slideDown(1);

            $('td[data-type="f'+cateid+'"]').find('span').remove()
            $('td[data-type="f'+cateid+'"]').append('<span>▼</span>');
            $("#fflag").val(0);

        }

        function delCate(cate_id){
            //询问框
            layer.confirm('确定要删除该分类吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post('{{url('admin/category/')}}/'+cate_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data) {
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
    </script>
@endsection