<?php
use Kamaro\Donation\Donation ;
class DonationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function getDonate($postid)
    {
        $postsDetails  = Post::find($postid);
        // Verify if the posts is still open 
        if ($postsDetails->Status!='Open') {
        	Flash::error('The post you are trying to donate to is closed, please try another post.');
		    return Redirect::to('home');
        }
        $postPublisher = Publisher::find($postsDetails->ID);

        return View::make('donate.donateform')
                   ->with('post',$postsDetails)
                   ->with('postPublisher', $postPublisher);
    }
    /**
     * Accept donation information
     * @return [description]
     */
   public function postDonate()
	{
		/////////////////////////////////
		// First validate input data //
		/////////////////////////////////
		if (! self::validateMsisdn(Input::get('msisdn')) && ! self::validatePin(Input::get('pin'))) {
         	Flash::error('Tigo Cash number and Pin are not valid. Please try again');
		    return Redirect::back();
		}
		if (! self::validateMsisdn(Input::get('msisdn'))) {
			Flash::error('Tigo Cash is not valid , only  072XXXXXXX format is acceptable.');
		    return Redirect::back();
		}
		if(! self::validatePin(Input::get('pin'))){
			Flash::error('Pin must be 4 numeric numbers. Please try again');
		    return Redirect::back();
		}

		// Every thing seems to be going well let's attempt to donate 
		 $donate = new Donation;
         $donate->postid = Input::get('postid');
         $donate->amount = Input::get('amount');
         $donate->msisdn = Input::get('msisdn');
         $donate->pin    = Input::get('pin');

        // Attempt to donate 
		if (! $donate->request()) {
		    Flash::error('Something went wrong while donating, Please make sure you use correct tigo cash number and pin .');
		    return Redirect::back();
		}
		//////////////////////
		// All goes well  //
		//////////////////////
         Flash::success('Thank you for donating '.number_format(Input::get('amount')).' RWF to  support <small>'.Post::find(Input::get('postid'))->description.'</small>');
		 return Redirect::back();
	}

    /**
     * Validate Tigo Rwanda MSISDN 
     */
	private static function validateMsisdn($msisdn){

        return ((strlen($msisdn)==10) && (substr($msisdn, 0,3)=='072'));  
	}

	/**
	 * Validate Tigo Cash pin
	 */
	private static function validatePin($pin){

		return (strlen($pin)==4 && intval($pin));
	}
}   