@extends('layouts.app')

@section('content')
<div id="welcome">
    <div class="jumbotron">
        <div class="container">
            <h1 class="jumbotron__header"><i class="fa fa-mobile"></i> Use Tigo Cash to Support.<i class="fa fa-mobile"></i> 
        </h1>
     @include('posts.search')
    </div>
    </div>
      @include('posts.postshome')   
</div>
@stop
