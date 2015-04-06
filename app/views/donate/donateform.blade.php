@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="form-donate">
           <h1 class="logo">Donate</h1>

   {{ Form::open(array('url' => '/posts/'.$post->ID.'/donate','class'=>'form-donate','role'=>'form')) }}
          <div class="form-group">
            <label for="recipient-name" class="control-label">Tigo Cash number:</label>
            <input type="text" class="form-control" name="msisdn" placeholder="Tigo Rwanda phone number (e.g:0722123000">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Amount:</label>
            <input type="text" class="form-control" name="amount" placeholder="Amount in Rwandan Francs">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">PIN:</label>
            <input type="text" class="form-control" name="pin" placeholder="Your tigo cash number (e.g: 0000)">
          </div>
         <div class="form-group buttons">
                <button type="submit" class="btn btn-primary">
                   <i class="fa fa-child fa-6"> Donate</i>
                </button>

                <a href="/" class="text-muted"><i class="fa fa-btn fa-list"></i> Go back to the posts</a>
            </div>
    {{Form::hidden('postid',$post->ID)}}
           
   {{ Form::close()}}
</div>
  </div>
</div>
@stop
