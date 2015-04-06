<?php namespace Kamaro\Notification;
/**
* Main class for sending notification using Tigo Rwanda MiddleWare
*/
class Notification
{

	public $username = "test_mw_osb";

	public $password = "tigo1234";

    //Send notification to MW soap 
    public function send()
     {
                  $request = $this->getRequest();

                  $soap_do = curl_init(); 
                  curl_setopt($soap_do, CURLOPT_URL,            $this->url );   
                  curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10); 
                  curl_setopt($soap_do, CURLOPT_TIMEOUT,        10); 
                  curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
                  curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);  
                  curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
                  curl_setopt($soap_do, CURLOPT_POST,           true ); 
                  curl_setopt($soap_do, CURLOPT_POSTFIELDS,    $request); 
                  curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml; charset=utf-8', 'Content-Length: '.strlen($request) )); 
                  curl_setopt($soap_do, CURLOPT_USERPWD, $this->user . ":" . $this->password);
                  
                  $result = curl_exec($soap_do);

         $response['status']      = $this->getStringBetween($result,'<v31:status>','</v31:status>');
         $response['code']        = $this->getStringBetween($result,'<v31:code>','</v31:code>');
         $response['description'] = $this->getStringBetween($result,'<v31:description>','</v31:description>');
         return $response;
      }
}