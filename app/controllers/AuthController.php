<?php
use  Kamaro\Notification\sendSms ;
class AuthController extends \BaseController {
 
  /**
   * Instance of the sms object
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
	public function login()
	{
		return View::make('auth.login');
	}
    
    public function signIn($value='')
    {
 
    $publisher = Publisher::where('email','=',Input::get('email'))
                          ->where('active','=',1)->first();


    if (empty($publisher)) {
      Flash::error('Oops ! we couldnt manage to authenticate you , Please make sure that you have registered and you account is activated');
      return Redirect::back();
    }
    $signInInfo = array(
    	               'email'   =>Input::get('email'), 
    	               'password'=>Input::get('password'),
                     'active'  =>1 
    	               );

    //Attempt to login 
    if (Auth::attempt( $signInInfo)) 
    {     
           return Redirect::to('publisher/dashboard');
    }   
    
    Flash::error('Your username/password combination was incorrect');
    return Redirect::to(URL::previous());
   
   }
    
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function register()
	{
		return View::make('auth.register');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
    $validator = Validator::make(Input::all(), Publisher::$rules);
 
    if ($validator->passes()) {
        // validation has passed, save user in DB
         $publiser = new Publisher;
         $publiser->firstname = Input::get('firstname');
         $publiser->lastname  = Input::get('lastname');
         $publiser->email     = Input::get('email');
         $publiser->msisdn    = Input::get('msisdn');
         $publiser->active    = false;
         $publiser->isadmin   = false;
         $publiser->password  = Hash::make(Input::get('password'));
        
         if ($publiser->save()) {
          $this->smsNotify($publiser->msisdn);
          //Write log
         Log::info('New publisher registered',compact(Input::all()));
         //Setting flash message
         Flash::success('Thanks for registering! We will get back to you after validating your account.');
         return Redirect::to('login');
       }        
       continue ;

    } 
        //Write log
        Log::error('Could not register user because ',compact($validator->messages()));

        Flash::error($validator->messages());
        // validation has failed, display error messages    
        return Redirect::to('register');
}
   /**
    * @brief Logout Publisher
    * @details 
    * 
    * @return Redirect
    */
   public function logout()
   {
   	 Auth::logout();
   	 
   	 return Redirect::to('/');
   }
   
   /**
    * @brief Reset pablisher password
    * @return string
    */
   public function forgot()
   {
     return View::make('auth.password');
   }
    /**
   * Display the password reset view for the given token.
   *
   * @param  string  $token
   * @return Response
   */
  public function getReset()
  {
   return View::make('auth.reset');
  }

  /**
   * Reset the given user's password.
   *
   * @param  Request  $request
   * @return Response
   */
  public function postReset()
  {
    /////////////////////////////////////////
    // Make validation rules and validates //
    /////////////////////////////////////////
    $rules= [
      'oldpassword' => 'required',
      'password' => 'required|confirmed',
    ];

    $validator = Validator::make(Input::all(),$rules);
    
    // Input valid?
    if ( ! $validator->passes()) {
      Flash::error($validator->messages());
      return Redirect::back();
    }

    $checkPassword = array(
                     'email'   =>Auth::user()->email, 
                     'password'=>Input::get('oldpassword'),
                     'active'  =>1 
                     );

    //Old password valid?
    if( !$errors=Auth::attempt($checkPassword)){

        Flash::error('Old password you provided is not valid');
        return Redirect::back();
    }
    
 
   $credentials = array('email' => $checkPassword['email']);

   $user = User::find(Auth::user()->id);
   $user->password = Hash::make(Input::get('password'));

  if ($user->save()) {
     Flash::success('Your password has been changed');
     return Redirect::to('publisher');
  }
 
  dd('byanze!');
      Auth::login($user);
      Flash::success('You password has been changed successfully ');
      return Redirect::to('publisher');

  }
public function request()
{
  $credentials = array('email' => Input::get('email'), 
                       'password' => Input::get('password')
                      );
 
  return Password::remind($credentials);
}
    /**
     * Notify subscriber
     */
    
    private function smsNotify($msisdn){

      $this->sms->destination = $msisdn;
      $this->sms->message     = 'Thanks for registering! We will get back to you after validating your account.';
      return $this->sms->send();
    }

 public function reset($token)
{
  return View::make('auth.resetguest')->with('token', $token);
}
   
public function update()
{
  $credentials = array('email' => Input::get('email'));
 
  return Password::reset($credentials, function($user, $password)
  {
    $user->password = Hash::make($password);
 
    $user->save();
 
    return Redirect::to('login')->with('flash', 'Your password has been reset');
  });
}
}
