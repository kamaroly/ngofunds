<div class="col-lg-3 panel panel-default">
                <div class="panel-heading"><strong>
                	<span class="fa fa-btn fa-list"></span>More from {{ $publisher }}</strong></div>
                <div class="panel-body">
                    @if (count($publisherposts)>0)
                    <ul>
                    @foreach ($publisherposts as $post) 
                        <li><a href="/posts/{{$post->ID}}/view">{{substr($post->Description, 0,20)}}</a></li>
                     @endforeach
                    </ul>
                    @else
                     <p>{{ $publisher }} doesn't have more posts.</p>
                    @endif
                </div>
          </div>
      </div>