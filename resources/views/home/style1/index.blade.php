@extends('home.style1.layouts.home')
@section('meta')
<title>{{config('web.web_title')}}</title>
<meta name="keywords" content="{{config('web.web_keywords')}}" />
<meta name="description" content="{{config('web.web_des')}}" />
@endsection
@section('content')

<div class="banner">
  <section class="box">
    <ul class="texts">
      <p>打了死结的青春，捆死一颗苍白绝望的灵魂。</p>
      <p>为自己掘一个坟墓来葬心，红尘一梦，不再追寻。</p>
      <p>加了锁的青春，不会再因谁而推开心门。</p>
    </ul>
    <div class="avatar"><a href="#"><span>灰鸽子zj</span></a> </div>
  </section>
</div>
<div class="template">
  <div class="box">
    <h3>
      <p><span>推荐文章</span> Recommend</p>
    </h3>
    <ul>
      @foreach($promote_art as $v)
      <li><a href="{{url('article/'.$v->art_id)}}"  ><img src="{{$v->art_thumb}}"></a><span>{{$v->art_title}}</span></li>
@endforeach

    </ul>
  </div>
</div>
<article>
  <h2 class="title_tj">
    <p>最新<span>文章</span></p>
  </h2>
  <div class="bloglist left">
  @foreach($data as $v)
      <a title="/" href="{{url('article/'.$v->art_id)}}">
        <h3>{{$v->art_title}}</h3></a>
    <figure>
        <a title="/" href="{{url('article/'.$v->art_id)}}">
      @if($v->art_thumb)
      <img src="{{$v->art_thumb}}">
        @else
        <img src="{{config('web.web_thumb')}}">
      @endif
        </a>
    </figure>
    <ul>
      <a title="/" href="{{url('article/'.$v->art_id)}}"><p>{{$v->art_description}}</p></a>
      <a title="/" href="{{url('article/'.$v->art_id)}}"  class="readmore">阅读全文>></a>
    </ul>
    <p class="dateview"><span>{{date('Y-m-d H:i:s',$v->art_addtime)}}</span><span>作者：{{$v->art_editor}}</span></p>
@endforeach
      <div class="page">
        {{$data->links('vendor.pagination.bootstrap-4')}}

      </div>
  </div>
  <aside class="right">



      <div class="weather"><iframe name="weather_inc" src="{{url('getWether')}}" style="border:solid 1px #7ec8ea" width="290" height="320" frameborder="0" marginwidth="0" marginheight="0" scrolling="no">

        </iframe></div>
    <div class="news">

@parent
    <h3 class="links">
      <p style="height: 35px">友情<span>链接</span></p>
    </h3>
    <ul >
      @foreach($links as $v)
        <li style="display: inline-block;    margin-bottom: 5px;"><a href="{{$v->link_url}}" title="{{$v->link_title}}" target="_blank">{{$v->link_name}}</a></li>
      @endforeach

    </ul> 
    </div>  

    </aside>
</article>
@endsection