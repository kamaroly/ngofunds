@extends('layouts.app')

@section('content')
<div class="container">
@include('posts.search')

    {{$posts->links()}}
<div class="row bs-docs-featured-sites">
	  @foreach ($posts as $post)
    <a href="/posts/{{$post->ID}}/view">
      <div class="col-xs-6 col-sm-3 post">
      <h2>{{$post->Description}} </h2>
      <i class="fa fa-picture-o fa-5x"></i>
      </div>
    </a>
    @endforeach
</div>
     {{$posts->links()}}
</div>
@stop
