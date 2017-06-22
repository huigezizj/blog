@extends('home.style1.layouts.home')
@section('meta')
    <title>{{$meta['title']}}-{{config('web.web_title')}}</title>
    <meta name="keywords" content="{{$meta['keywords']}}" />
    <meta name="description" content="{{$meta['description']}}" />
@endsection
@section('content')
<article class="blogs">
<h1 class="t_nav"><span>{{$cate->cate_title}}</span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('cate/'.$cate->cate_id)}}" class="n2">{{$cate->cate_name}}</a></h1>
<div class="newblog left">


@foreach($data as $v)

            <h2>
                <span>[<a style="color: #f90;" href="{{url('cate/'.$v->cate_id)}}">{{$v->cate_name}}</a>]</span><a href="{{url('article/'.$v->art_id)}}"> {{$v->art_title}}</a></h2>
   <p class="dateview1"><span>发布时间：{{date('Y-m-d H:i:s',$v->art_addtime)}}</span><span>作者：{{$v->art_editor}}</span><span>浏览：{{$v->art_view}}</span></p>
        <a href="{{url('article/'.$v->art_id)}}"><figure>
        @if($v->art_thumb)
        <img src="/{{$v->art_thumb}}">
            @else
            <img src="/{{config('web.web_thumb')}}">
        @endif

            </figure></a>

    <ul class="nlist">
      <p>{{$v->art_description}}</p>
      <a title="{{$v->art_title}}" href="{{url('article/'.$v->art_id)}}"  class="readmore">阅读全文>></a>
    </ul>
    <div class="line"></div>
@endforeach



    <div class="blank"></div>
    <div class="ad">  
    {{--<img src="images/ad.png">--}}
    </div>
    <div class="page">
{{$data->links('vendor.pagination.bootstrap-4')}}
    </div>
</div>
<aside class="right">
   <div class="rnav">
      <ul>
          @foreach($sub_cate as $k =>$v)
       <li class="rnav{{$k+1}}"+><a href="{{url('/cate/'.$v->cate_id)}}" >{{$v->cate_title}}</a></li>
            @endforeach
     </ul>      
    </div>
<div class="news">
@parent

</aside>
</article>

    @endsection