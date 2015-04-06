@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="panel panel-default">
                <div class="panel-heading"><strong>
                	<span class="fa fa-btn fa-list"></span>{{ Auth::user()->firstname }} 's posts </strong></div>
                <div class="panel-body">
                	{{$posts->links()}}
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Details</th>
                                <th>Views</th>
                                <th>Donations</th>
                                <th>Status</th>
                                <th>&nbsp;<i class="fa fa-cog fa-fw"></i>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($posts as $post) 
                            <tr>
                                <td>{{$post->ID}}</td>
                                <td>{{substr($post->Description, 0,20)}}</td>
                                <td>{{substr($post->Details, 0,40)}}</td>
                                <td>{{$post->TotalViews}}</td>
                                <td>{{$post->TotalDonations}}</td>
                                <td>{{$post->Status}}</td>
                                <td><a href="/posts/{{$post->ID}}/view" class="btn btn-sm btn-success">
                                    <i class="fa fa-pencil-square"> View</i>
                                 </a>
                                </td>
                            </tr>
                         @endforeach
                        </tbody>
                    </table>
                    {{$posts->links()}}
                </div>
            </div>
           </div>
    @stop
