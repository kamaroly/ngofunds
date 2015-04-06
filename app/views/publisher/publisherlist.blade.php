@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<section class="panel panel-default">
        <div class="panel-heading"><strong><span class="fa fa-btn fa-users"></span>Publishers</strong></div>
        <div class="panel-body">
            <section class="table-flip-scroll">
                <table class="table table-bordered table-striped cf">
                    <thead class="cf">
                        <tr>
                            <th>First name</th>
                            <th>Last name</th>
                            <th class="numeric">E-Mail</th>
                            <th class="numeric">Msisdn</th>
                            <th class="numeric">Resume</th>
                            <th class="numeric">MfiNumber</th>
                            <th class="numeric">Status</th>
                            <th class="numeric"><i class="fa fa-cog fa-fw"></i> </th>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach ($publishers as $publisher) 
                        <tr>
                            <td>{{$publisher->firstname}}</td>
                            <td>{{$publisher->lastname}}</td>
                            <td >{{$publisher->email}}</td>
                            <td >{{$publisher->msisdn}}</td>
                            <td >{{$publisher->Resume}}</td>
                            <td >{{$publisher->MfiNumber}}</td>
                            <td >{{($publisher->active)?'Actived':'Not activated'}}</td>
                            <td > @if($publisher->active)
                                  <a class="btn btn-small btn-primary" href="/publishers/{{$publisher->id}}/change/{{$publisher->active}}"><i class="fa fa-check"></i></a>
                                  @else
                                  <a class="btn btn-small btn-danger" href="/publishers/{{$publisher->id}}/change/{{$publisher->active}}"><i class="fa fa-remove"></i></a>
                                 @endif
                              </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </section>
    </div>

</div>
</section>
</div>
</div>
@stop