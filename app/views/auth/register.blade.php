@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">Register</div>
			<div class="panel-body">

				@include('partials.errors.basic')

				<form class="form-horizontal" role="form" method="POST" action="/register">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group">
						<label for="firstname" class="col-sm-3 control-label">First Name</label>
						<div class="col-sm-6">
							<input type="text" id="firstname" name="firstname" class="form-control" placeholder="first name">
						</div>
					</div>

				  <div class="form-group">
						<label for="lastname" class="col-sm-3 control-label">Last Name</label>
						<div class="col-sm-6">
							<input type="text" id="lastname" name="lastname" class="form-control" placeholder="last name" >
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-3 control-label">Email</label>
						<div class="col-sm-6">
							<input type="email" id="email" name="email" class="form-control" placeholder="Email" autocapitalize="off">
						</div>
					</div>
                    <div class="form-group">
						<label for="email" class="col-sm-3 control-label">Phone number</label>
						<div class="col-sm-6">
							<input type="telephone" id="msisdn" name="msisdn" class="form-control" placeholder="25072xxxxx" autocapitalize="off" >
						</div>
					</div>
                	<div class="form-group">
						<label for="password" class="col-sm-3 control-label">Password</label>
						<div class="col-sm-6">
							<input type="password" name="password" class="form-control" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-3 control-label">Confirm Password</label>
						<div class="col-sm-6">
							<input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-3">
							<button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-user"></i>Register</button>
						</div>
			
				</form>

			</div>
		</div>
	</div>
</div>
</div>
@stop
