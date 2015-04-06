<?php
use  Kamaro\Notification\sendSms ;
class PostController extends \BaseController {
    /**
     * Sms object instance
     */
    protected $sms;

    public function __construct(sendSms $sms) {
        $this->sms = $sms;
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	 public function index()
	 {
	  	$post = Post::where('Status','=','Open')
                    ->paginate(16);

	    return View::make('posts.postlist')
	             ->with('posts',$post);
	 }
  
   /**
    * @brief Search through the posts
    */
    public function Search()
    {
    	try {
    	 	$posts = Post::search(Input::get('search'))->paginate(30);
    	 	
    	    //worn user for empty search
    	    if(empty(Input::get('search'))){
    	    	Flash::warning('You did not tell us what to search for !');
    	    	return Redirect::to(URL::previous());
    	    }
   
            Log::info('Searching for posts with '.Input::get('search').' as Keyword returns '.$posts->count());

    	    return View::make('posts.postlist')
	                   ->with('posts',$posts);

    	 } catch (Exception $e) {

            Log::error('Cannot find what you are looking for '.' ['.$e.']');
    	 	Flash::warning('Something went wrong while searching');
    	 	return Redirect::to(URL::previous());
    	 }
    }
    /**
     * Display details of the post
     */

	public function view($id)
	{
	
	  $post = Post::find($id);
	  
	  if($post) {
        //Let's see if we have more post from this same publisher
       $PublisherPosts = Post::where('publisher','=',$post->Publisher)
                             ->where('ID','!=',$post->ID)
                             ->get()
                             ->take(20);
       
       $PublisherFirstname = '';
       if(count($PublisherPosts)>0){
       //Let's get publisher name                             
       $PublisherFirstname = ( ! is_null($publisher=Publisher::where('id','=',$post->Publisher)->first()))?$publisher->firstname:null;
       }
        
        //Increment the number of viewers
        Post::where('ID','=',$id)
            ->update(['TotalViews'=>$post->TotalViews+1]);
     
 	    return View::make('posts.view')
	               ->with('post',$post)
                   ->with('publisherposts',(count($PublisherPosts)>0)?$PublisherPosts:array())
                   ->with('publisher',$PublisherFirstname);
	    }

         Log::error('Unable to find the page you are looking for with '.Input::get('search').' as Keyword.');
	 
	  	 Flash::error('Unable to find the page you are looking for');
	  	 return Response::view('partials.errors.404', array(), 404);  
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
     		return View::make('posts.new');
	}
    
    /**
     * @brief store posts in the database
     * @details [long description]
     * @return [description]
     */
	public function store()
	{  
         $validator = Validator::make(Input::all(), Post::$rules);
 
        if (! $validator->passes()){
            Log::error('Validation failed with data '.json_encode(Input::all()));
            Flash::error($validator->messages());
            // validation has failed, display error messages    
            return Redirect::back();
        }    
      try {
     
        // Try to get image
        $image =false;
    
        if($image=Input::file('image')){
            
            $filetype =Input::file('image')->guessClientExtension();
            if ($filetype!='png' && $filetype!='PNG' && $filetype!='jpg' && $filetype!='JPEG') {
               Log::error('Unsupported filetype '.$filetype.' Only PNG and JPEG are supported');
               Flash::error('Unsupported filetype '.$filetype.' Only PNG and JPEG are supported');
               return Redirect::back();    
            }

            $img_data = file_get_contents($this->upload());
            $image='data:image/png;base64,'.base64_encode($img_data);
        }
        $Post  = new Post;
        $Post->Publisher  = 1;
        $Post->PostedDate = date('Y-m-d h:m:i');
        $Post->ExpirationDate = date('Y-m-d h:m:i');
        $Post->Description= Input::get('Description');
        $Post->Details    = Input::get('Details');
        $Post->TotalViews = 0;
        $Post->Status     ='Open';
        $Post->Picture    =$image;
        $Post->save();
         
        Log::info('New post created with ID '.$Post->ID.' by '.Auth::user()->firstname);
	  	  
        Flash::success('New post added');
        return Redirect::to('posts');

		} catch (Exception $e) {
		 
		 Log::error('Error Occured while creating a post '.' ['.$e.']');

		 Flash::error('Something went Wrong while saving');
         return Redirect::to('posts');
		
		}
    }

    /**
     * Display view and data for modification
     */
    public function edit($id)
    {
      $post = Post::find($id);
	  return View::make('posts.new')
	             ->with('post',$post);
    }

    /**
     * @brief Store modified post
     * @details [long description]
     * 
     * @param  PostID
     * @return Redict
     */
    public function storeEdit($id)
	{
		try {
			$Post=Post::where('ID','=',$id)
		              ->update(Input::all());
       
           Log::info('Post with ID'.$Post->ID.' modified with '.implode(',', Input::all()));
           Flash::success('Post modified!');

           return Redirect::to('posts');

		} catch (Exception $e) {
          
           Log::error('Could not edit the post '.' ['.$e.']');

		   Flash::error('Could not edit the post');
           return Redirect::to('posts');
		}      
    }
    

    /**
     * Destroy post
     */
    public function destroy($id)
    {
    	try {
    		
    		Post::destroy($id);

    		Log::info('Deleted post with ID '.$id);

    		Flash::success('Post deleted');
    		return Redirect::to('posts');

    	} catch (Exception $e) {
    		Log::info('Something went wrong while trying to delete post with id '.$id.' ['.$e.']');
    		Flash::error('Something went wrong while deleting a post'.$e);
    		return Redirect::to('posts');
    	}
    }    

 /**
  * Upload image
  */
   
   private function upload(){
    //Get Random  image name
   $filename = str_random(12);
   $imagename=Input::file('image')
                     ->move(storage_path().'/uploadedimages/',$filename.'.'.Input::file('image')
                     ->guessClientExtension());
   
   $extension = Input::file('image')->guessClientExtension();

   $data = file_get_contents($imagename);

   return   $base64 = 'data:image/' . $extension . ';base64,' . base64_encode($data);
    
   }
}
