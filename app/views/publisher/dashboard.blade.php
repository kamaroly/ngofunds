@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">Dashboard</div>
			<div class="panel-body">

				<div class="row text-center">
        <div class="col-lg-3 col-xsm-6">
            <div class="panel mini-box">
                <span class="btn-icon btn-icon-round btn-icon-lg-alt bg-success">
                    <span class="fa fa-money fa-lg"></span>
                </span>
                <div class="box-info">
                    <p class="size-h2">{{number_format($donations)}} <span class="size-h4">Rwf</span></p>
                    <p class="text-muted"><span data-i18n="Growth">Donations</span></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xsm-6">
            <div class="panel mini-box">
                <span class="btn-icon btn-icon-round btn-icon-lg-alt bg-info">
                    <i class="fa fa-th"></i>
                </span>
                <div class="box-info">
                    <p class="size-h2">{{number_format($views)}} <span class="size-h4"></span></p>
                    <p class="text-muted"><span data-i18n="New users">Total views</span></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xsm-6">
            <div class="panel mini-box">
                <span class="btn-icon btn-icon-round btn-icon-lg-alt btn-success">
                    <i class="fa fa-align-justify"></i>
                </span>
                <div class="box-info">
                    <p class="size-h2">{{number_format($totalPosts)}}</p>
                    <p class="text-muted"><span data-i18n="Profit">Number of posts</span></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xsm-6">
            <div class="panel mini-box">
                <span class="btn-icon btn-icon-round btn-icon-lg-alt bg-danger">
                    <i class="fa fa-times"></i>
                </span>
                <div class="box-info">
                    <p class="size-h2">{{number_format($inactiveposts)}}</p>
                    <p class="text-muted"><span data-i18n="Sales">Closed posts</span></p>
                </div>
            </div>
        </div>
    </div>
			</div>
		</div>
	</div>
</div>
@stop
