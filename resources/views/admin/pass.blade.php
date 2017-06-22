@extends('admin.layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 修改密码
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>修改密码</h3>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form method="{{url('admin/pass')}}" onsubmit="return changePass()">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>原密码：</th>
                <td>
                    <input type="password" name="password_o"> </i>请输入原始密码</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>新密码：</th>
                <td>
                    <input type="password" name="password"> </i>新密码6-20位</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>确认密码：</th>
                <td>
                    <input type="password" name="password_confirmation"> </i>再次输入密码</span>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="button" onclick="subpass()" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回"><span id="masg" style="color: orangered"></span>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
    <script>
        function subpass() {
            var password=$('input[name="password"]').val();
            var password_confirmation=$('input[name="password_confirmation"]').val();
            var password_o=$('input[name="password_o"]').val();

            $.post('{{url('admin/pass')}}',{'_token':'{{ csrf_token() }}',password:password,password_confirmation:password_confirmation,password_o:password_o
            },function(data){
                if (data==1) {
                    $('#masg').text('密码修改成功！');
                    setTimeout("top.location.href = '{{url('admin/index')}}'",1000);

                    return false;
                }
                $('#masg').text(data);
            });
        }
    </script>
</div>
@endsection
