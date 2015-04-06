@extends('layouts.app')

@section('content')

<script src="/js/vendor/ckeditor.js"></script>
<link href="/css/ckeditor.css" rel="stylesheet">

<div class="container">
<div class="row">

		{{ Form::open(array('url'=>'/publisher/posts/new','files'=> true))}}
		
		<label>Title</label>
		<input name="Description" class="form-control" id="title" value="{{isset($post)?$post->Description:''}}">
		<!--<input class="form-control" type="hidden" desabled name="slug" id="slug" > -->
		{{Form::label('image', 'Picture :',array('class'=>'form-control'))}}
		{{Form::file('image');}}
			<label>Body</label>
			<p>
			<textarea class="ckeditor" cols="80" id="editor1" name="Details" rows="10">
			{{isset($post)?$post->Details:''}}
			</textarea>
		</p>
		<p>
			<input type="submit" value="Save" class="btn btn-success">
			<input type="reset" value="Clear" class="btn btn-inverse">
		</p>

	    {{ Form::close() }}
@stop