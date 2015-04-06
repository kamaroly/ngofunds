{{Form::open(array('url' => 'posts/search','method'=>'GET'))}}
   <div class="input-group col-xs-6 col-sm-6 ">
    <input type="text" name="search" class="form-control" placeholder="Search for a post to donate"/>
    <span class="input-group-addon">
       <button > <i class="fa fa-search"></i></button>
    </span>
  </div>
{{Form::close()}}