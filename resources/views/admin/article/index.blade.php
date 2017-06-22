@extends('admin.layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">

        <form action="{{url('admin/article/search')}}" method="post">
            {{csrf_field()}}
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        {{--<select onchange="javascript:location.href=this.value;">--}}
                        <select  name="cate_id">
                            <option value="0">全部</option>

                            @if(isset($cate))
                                @foreach($cate as $v)

                                    <option value="{{$v['cate_id']}}">{{$v['cate_name']}}</option>
                                @endforeach
                            @endif

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
                <h3>文章列表</h3>
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
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                    <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
                    <a href="javascript:;" onclick="multDelete()"><i class="fa fa-recycle"></i>批量删除</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%"><input type="checkbox" name=""></th>
                        <th  width="5%" class="tc">ID</th>
                        <th>标题</th>
                        <th width="7%">栏目</th>
                        <th width="3%">点击</th>
                        <th  width="10%">编辑</th>
                        <th width="10%">发布时间</th>
                        <th width="7%">操作</th>
                    </tr>


                    @foreach($data as $v)
                    <tr>
                        <td class="tc"><input type="checkbox" name="id[]" value="{{$v->art_id}}"></td>

                        <td class="tc">{{$v->art_id}}</td>
                        <td>
                            <a href="#">{{$v->art_title}}</a>
                        </td>
                        <td>{{$v->cate_name}}</td>
                        <td>{{$v->art_view}}</td>
                        <td>{{$v->art_editor}}</td>
                        <td>{{date('Y-m-d H:i:s',$v->art_addtime)}}</td>
                        <td>
                            <a href="{{url('admin/article/'.$v->art_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delArt({{$v->art_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach


                </table>




                <div class="page_list">
                    @if(isset($keywords))
                        {!! $data->appends(array('keywords'=>$keywords))->render() !!}
                    @else
                        {{$data->links('vendor.pagination.bootstrap-4')}} <ul><span class="rows" style="    line-height: 30px;"><h5>Page {{$data->currentPage() }} of {{$data->lastPage()}}</h5></span></ul>

                    @endif                </div>
            </div>
        </div>
    </form>

    <!--搜索结果页面 列表 结束-->
    <script>
        function delArt(art_id){
            //询问框
            layer.confirm('确定要删除该文章吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post('{{url('admin/article/')}}/'+art_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data) {
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
        function multDelete() {
            //选择所有name="'test'"的对象，返回数组
            var obj=document.getElementsByName('id[]');
            //取到对象数组后，我们来循环检测它是不是被选中
            var s='';
            for(var i=0; i<obj.length; i++){
                if (i==0) {

                    if(obj[i].checked) s+=obj[i].value; //如果选中，将value添加到变量s中
                }else {
                    if(obj[i].checked) s+=','+obj[i].value; //如果选中，将value添加到变量s中
                }
            }
            //那么现在来检测s的值就知道选中的复选框的值了
            if (s=='') {
                layer.msg('你还没有选择任何内容',{icon:5});
            }else{
                layer.confirm('确定要删除的链接id：'+s, {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    $.post('{{url('admin/article/multDelete')}}', {'ids': s,'_token':'{{csrf_token()}}'}, function (data) {
                        if (data.status==0) {
                            layer.msg(data.msg);
                            location.reload();
                        }else{
                            layer.msg(data.msg,{icon:5});
                        }
                    });
                });
            }
        }


    </script>

@endsection