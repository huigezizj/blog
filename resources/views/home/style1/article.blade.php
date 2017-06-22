@extends('home.style1.layouts.home')
@section('meta')
    <title>{{$art->art_title}}-{{config('web.web_title')}}</title>
    <meta name="keywords" content="{{$art->art_tag}}" />
    <meta name="description" content="{{$art->art_description}}" />
@endsection
@section('content')

<article class="blogs">
  <h1 class="t_nav">
      {{--<span>您当前的位置：--}}
          {{--<a href="{{url('/')}}">首页</a>&nbsp;&gt;&nbsp;--}}
          {{--<a href="/news/s/">慢生活</a>&nbsp;&gt;&nbsp;--}}
          {{--<a href="/news/s/">日记</a></span>--}}

      <a href="{{url('/')}}" class="n1">网站首页</a>
      <a href="{{url('cate/'.$cate->cate_id)}}" class="n2">{{$cate->cate_name}}</a></h1>

  <div class="index_about">
    <h2 class="c_titile">{{$art->art_title}}</h2>
    <p class="box_c"><span class="d_time">发布时间：{{date('Y-m-d H:i:s',$art->art_addtime)}}</span><span>编辑：{{$art->art_editor}}</span><span>查看次数：{{$art->art_view}}</span></p>
    <ul class="infos">{!! $art->art_content !!}</ul>
    <div class="keybq">
    <p><span>关键字词</span>：{{$art->art_tag}}</p>
    
    </div>
    <div class="ad"> </div>
    <div class="nextinfo">
        @if(isset($art['pre']->art_title))
      <p>上一篇：<a href="{{url('article/'.$art['pre']->art_id)}}">{{$art['pre']->art_title}}</a></p>
        @else
            <p>上一篇：没有了</p>
        @endif
        @if(isset($art['next']->art_title))
      <p>下一篇：<a href="{{url('article/'.$art['next']->art_id)}}">{{$art['next']->art_title}}</a></p>
            @else
            <p>下一篇：没有了</p>
        @endif
    </div>
    <div class="otherlink">
      <h2>相关文章</h2>
      <ul>

          @foreach($data as $v)
        <li><a href="{{url('article/'.$v->art_id)}}" title="{{$v->art_title}}">{{$v->art_title}}</a></li>
@endforeach

      </ul>
    </div>
  </div>
  <aside class="right">

    <div class="blank"></div>
      <div class="rnav">
          <ul>
              @foreach($sub_cate as $k =>$v)
                  <li class="rnav{{$k+1}}"+><a href="{{url('/cate/'.$v->cate_id)}}" >{{$v->cate_title}}</a></li>
              @endforeach
          </ul>
      </div>
    <div class="news">
     @parent
    </div>

  </aside>
</article>

    @endsection