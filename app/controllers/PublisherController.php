<?php
use  Kamaro\Notification\sendSms as sendSms;

class PublisherController extends \BaseController {

   
  /**
   * Instance of the sms object
   */
  protected $sms;

  public function __construct(sendSms $sms) {
 
   $this->sms = $sms;
   
  }

    public function index()
    {
    	//Check if the person is allowed to access this page
    	if (! Auth::user()->isadmin) {
    		Flash::warning('Only administrator can access the page you are trying to access');
            //Taking him back
            return Redirect::back();
    	}

    	$publishers = Publisher::paginate(20);
    	return View::make('publisher.publisherlist')
    	           ->with('publishers',$publishers);
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function dashboard()
	{   

		// Initializing variables to be passed tot the view
		$totalDonatation=0;
        $totalViews=0;
	    $totalPosts=0;
        $inactiveposts=0;
		//////////////////////////////////////////////////////////////////////
	    // if the user is not admin get information related to him only 	 //
		//////////////////////////////////////////////////////////////////////

	 if( Auth::user()->isadmin==0)
	  {
	    $totalDonatation += Post::where('publisher','=',Auth::user()->id)
	                            ->sum('TotalDonations');

        $totalViews     += Post::where('publisher','=',Auth::user()->id)
	                            ->sum('TotalViews');

	    $totalPosts      += Post::where('publisher','=',Auth::user()->id)
	                            ->count('ID');     
        
        $inactiveposts   += Post::where('publisher','=',Auth::user()->id)
                                ->where('Status','!=','Open')
	                            ->count('ID'); 
       		
		}
		else
		{
	    $totalDonatation+= Post::sum('TotalDonations');

        $totalViews     += Post::sum('TotalViews');

	    $totalPosts     += Post::count('ID');     
        
        $inactiveposts  += Post::where('Status','!=','Open')
	                           ->count('ID'); 
		}

		return View::make('publisher.dashboard')
		           ->with('donations',$totalDonatation)
		           ->with('views',$totalViews)
		           ->with('totalPosts',$totalPosts)
		           ->with('inactiveposts',$inactiveposts);
	}
    
    //Get posts that belongs to this publisher
    public function PublisherPosts()
    {
    	$posts = Post::where('publisher','=',Auth::user()->id)
    	             ->paginate(10);
    	return View::make('posts.posttable')
    	            ->with('posts',$posts);
    }

    /**
     * Change the status of the publisher
     */
    
    public function changeStatus($id,$status)
    {

        // Will return a ModelNotFoundException if no user with that id
         try
         {
             $user = Publisher::find($id);

             $user->active = ($status==0)?1:0;

             $user->save();

             $status = ($status==0)?'activated':'Deactivated';
             
             $message = 'Hi '.$user->firstname.', kindly be informed that your account has been '.$status;
             
            
             /////////////////
             // Notify user //
             /////////////////
              $this->sms->destination = $user->msisdn;
              $this->sms->message     = $message;
              $this->sms->send();

             Flash::success('Publisher named <strong>'.$user->firstname.' '.$user->lastname.'</strong> is '.$status);
      
             return Redirect::back();
         }
         // catch(Exception $e) catch any exception
         catch(ModelNotFoundException $e)
             {
        
             Flash::error(' Oops! We could not understand what you want to do');
             return Response::view('partials.errors.404', array(), 404);
         }
       
    }
    
  

}
