<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    @yield('meta')
    <link href="{{asset('public/home/'.config('web.web_style').'/css/base.css')}}" rel="stylesheet">
    <link href="{{asset('public/home/'.config('web.web_style').'/css/index.css')}} " rel="stylesheet">
    <link href="{{asset('public/home/'.config('web.web_style').'/css/style.css')}} " rel="stylesheet">
    <link href="{{asset('public/home/'.config('web.web_style').'/css/new.css')}} " rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="{{asset('public/home/'.config('web.web_style').'/js/modernizr.js')}} "></script>
    <![endif]-->
</head>
<body>
<header>
  <div id="logo"><a href="{{url('/')}}"></a></div>
  <nav class="topnav" id="topnav">

      @foreach($nav as $v)
      <a href="{{$v->nav_url}}"><span>{{$v->nav_name}}</span><span class="en">{{$v->nav_tips}}</span></a>
          @endforeach

  </nav>
</header>

@section('content')

    <h3>
        <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
        @foreach($new as $v)
        <li><a href="{{url('article/'.$v->art_id)}}" title="{{$v->art_title}}" >{{$v->art_title}}</a></li>
        @endforeach
    </ul>
    <h3 class="ph">
        <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
        @foreach($hot as $v)
            <li><a href="{{url('article/'.$v->art_id)}}" title="{{$v->art_title}}" >{{$v->art_title}}</a></li>
        @endforeach
    </ul>
    <div class="visitors">
        <h3>
            <p>最近访客</p>

        </h3>

        <ul>

            @if(is_array(session('visitor')))
                @foreach(session('visitor') as $k=>$v)
<li>{{date('Y-m-d H:i',$v['time'])}}:{{$v[0]}}{{$v[1]}}{{$v[2]}}{{$v[3]}}{{$v[4]}}&nbsp;{{$k}}</li>
                @endforeach
            @endif
        </ul>
    </div>
    </div>

    @show

<footer>
  <p>Design by huigezizj <a href="http://huigezizj.cc/" >http://huigezizj.cc</a> <a href="/">网站统计</a></p>
</footer>
{{--<script src="{{asset('public/home/'.config('web.web_style').'/js/silder.js')}} "></script>--}}
</body>
</html>
