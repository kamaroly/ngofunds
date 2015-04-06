@extends('layouts.app')

@section('content')
@section('content')
<div class="container">
<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">Forgotten Password</div>
			<div class="panel-body">
@if (Session::has('error'))
  {{ trans(Session::get('reason')) }}
@endif
 
{{ Form::open(array('route' => array('password.update', $token,
                                   ))) }}
 
  <p>{{ Form::label('email', 'Email',['class'=>'col-sm-3 control-label']) }}
  {{ Form::text('email') }}</p>
 
  <p>{{ Form::label('password', 'Password') }}
  {{ Form::text('password') }}</p>
 
  <p>{{ Form::label('password_confirmation', 'Password confirm') }}
  {{ Form::text('password_confirmation') }}</p>
 
  {{ Form::hidden('token', $token) }}
 
  <p>{{ Form::submit('Submit') }}</p>
 
{{ Form::close() }}
</div>
</div>
</div>
</div>
</div>
</div>
@stop