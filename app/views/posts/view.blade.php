@extends('layouts.app')

@section('content')
<div id="welcome">
    <div class="jumbotron">
        <div class="container">
        <div class="jumbotron_header_small">
            <h1>{{$post->Status}}</h1>
        </div>
    </div>
  </div>
 <div class="container">
   <div class="row">
       <div class="col-lg-9">
        <h2 class="description">
              <i class="fa fa-support"></i> {{$post->Description}} 
              <i class="fa fa-support"></i> 
           </h2>
         @if(!(Auth::check()) && ($post->Status=='Open'))
          <a href="/posts/{{$post->ID}}/donate" class="btn btn-primary btn-lg" >
          <h1>
              <i class="fa fa-child fa-6"> Donate</i> 
          </h1>
          </a>
         @endif
          <br>
         <p>{{$post->Details}}</p>
  </div>

         @if(count($publisherposts)>0)
          @include('publisher.publisherposts')
         @endif
  </div>
 </div>

@stop
