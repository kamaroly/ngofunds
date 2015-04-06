<?php
/////////////////////////////
// welcome and home routes //
/////////////////////////////
Route::get('/', 'HomeController@showWelcome');
Route::get('/home', 'HomeController@showWelcome');

///////////////////////////////////////////////
// User Authentication & Registration Routes //
///////////////////////////////////////////////

Route::get('login', 'AuthController@login');
Route::post('login', 'AuthController@signIn');
Route::get('register', 'AuthController@register');
Route::post('register','AuthController@store');
Route::get('logout', 'AuthController@logout');
/////////////////////
// Reset password  //
/////////////////////
Route::get('password/email', 'AuthController@forgot');
Route::post('password/email', 'AuthController@request');
Route::get('password/reset/{token}', array(
  'uses' => 'AuthController@reset',
  'as' => 'password.reset'
));

Route::post('password/reset/{token}', array(
  'uses' => 'AuthController@update',
  'as' => 'password.update'
));
//////////////////
// Posts  public routes routes //
//////////////////

Route::group(array('prefix' => 'posts'), function()
{
	Route::get('/{id}/view','PostController@view');
    Route::get('/', 'PostController@index');

    Route::get('/{postid}/donate','DonationController@getDonate');
    Route::post('/{postid}/donate','DonationController@postDonate');

    Route::get('/search','PostController@Search');
});

//////////////////////
// publisher routes //
//////////////////////

Route::group(array('prefix'=>'publisher','before'=>'auth'),function()
{   
	Route::get('/','PublisherController@dashboard');

	Route::get('/posts','PublisherController@PublisherPosts');
   
    Route::get('/posts/new','PostController@create');
    Route::post('/posts/new','PostController@store');
    
    Route::get('/posts/{id}','PostController@view');
    Route::get('/posts/{id}/delete','PostController@destroy');
    
    Route::get('dashboard','PublisherController@dashboard');
});

Route::group(array('prefix'=>'publishers','before'=>'auth'),function()
{ 
  Route::get('/change/password','AuthController@getReset');  
  Route::post('/change/password','AuthController@postReset'); 

  Route::get('/','PublisherController@index');
  Route::get('/{publisherid}/change/{status}','PublisherController@changeStatus');
});

//////////////////////////////
// Error handling //
//////////////////////////////
App::missing(function($exception)
{
    return Response::view('partials.errors.404', array(), 404);
});

// App::fatal(function($exception)
// {
//    return Response::view('partials.errors.500', $exception->getMessage(), 500);
// });

//////////////////
// Test routes  //
////////////////////
use Kamaro\Donation\Donation ;
use Kamaro\Notification\sendSms ;
use Kamaro\Validators\MfsCheckPin ;

Route::get('/sendSms',function(){   

   $sms = new  sendSms;
   $sms->destination = '250722123127';
   $sms->message     = 'Test sms ';
   $sms->url         =$url = 'http://10.138.84.138:8002/osb/services/SendNotification_1_0';
   dd($sms->send());
});

Route::get('/donate',function(){   
   $donate = new Donation;
   $donate->postid = 5;
   $donate->amount = 100;
   $donate->msisdn ='0722123270';
   $donate->pin    = 2586;
   
   dd($donate->request());
});


Route::get('/pincheck',function(){
 
 dd((new MfsCheckPin)->request());
});

Route::get('/image', function()
{
  return '<img width="16" height="16" alt="star" src="data:image/gif;base64,R0lGODlhEAAQAMQAAORHHOVSKudfOulrSOp3WOyDZu6QdvCchPGolfO0o/XBs/fNwfjZ0frl3/zy7////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAkAABAALAAAAAAQABAAAAVVICSOZGlCQAosJ6mu7fiyZeKqNKToQGDsM8hBADgUXoGAiqhSvp5QAnQKGIgUhwFUYLCVDFCrKUE1lBavAViFIDlTImbKC5Gm2hB0SlBCBMQiB0UjIQA7" />';   
});



