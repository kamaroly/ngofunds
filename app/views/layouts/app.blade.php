<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Application Title -->
	<title>NGOs Funds</title>

	<!-- Bootstrap CSS -->
	<link href="/css/app.css" rel="stylesheet">
	<link href="/css/vendor/font-awesome.css" rel="stylesheet">



	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<!-- Static navbar -->
	<nav class="navbar navbar-default navbar-static-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">NGos Funds</a>
			</div>

			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="/posts">Browse Post</a></li>
				</ul>

				@if (!Auth::guest())
					<ul class="nav navbar-nav navbar-right">
						
						<li>
							<a href="/publisher/dashboard"><i class="fa fa-btn fa-dashboard"></i>Dashboard</a>
						</li>
						<li>
							<a href="/publisher/posts"><i class="fa fa-btn fa-btn fa-list"></i>My Posts</a>
						</li>
                    	<li>
							<a href="/publisher/posts/new"><i class="fa fa-btn fa-plus"></i>Add a post</a>
						</li>
                @if( Auth::user()->isadmin )
                        <li>
                            <a href="/publishers" ><i class="fa fa-btn fa-users"></i>Publishers</a>
                        </li>
                @endif
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                				<i class="fa fa-btn fa-user"></i>
								{{ Auth::user()->lastname }} {{ Auth::user()->firstname }} <b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
							<li><a href="/publishers/change/password"><i class="fa fa-btn fa-cogs"></i>Change password</a></li>
							<li><a href="/logout"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
							</ul>
						</li>
					</ul>
				@else
					<ul class="nav navbar-nav navbar-right">
					<li><a href="/login"><i class="fa fa-btn fa-sign-in"></i>Login</a></li>
					<li><a href="/register"><i class="fa fa-btn fa-user"></i>Register</a></li>
					</ul>
				@endif
			</div>
		</div>
	</nav>
    <!--Notification Area-->
    <div class="container">
       <div class="row">
            @include('flash::message')
       </div>
    </div>

	@yield('content')


<div class="container">
<div class="footer_bottom">
            <p class="pull-left">
                © NGos Funds {{Date('Y')}}. All rights reserved.
            </p>

            <div class="pull-right">
                Proudly hosted with <a href="http://tigo.co.rw" target="_blank">Tigo Rwanda</a> .
            </div>
 </div>
</div>
	<!-- Bootstrap JavaScript -->
	<script src="/js/vendor/jquery.js"></script>
	<script src="/js/vendor/bootstrap.js"></script>
	<script type="text/javascript">
$("#title").keyup(function(){

        var Text = $(this).val();
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
        $("#slug").val(Text);        
});

    $('#flash-overlay-modal').modal();
</script>
</body>
</html>
