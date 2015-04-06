<?php namespace Kamaro\Traits;
/**
 * Most used SOAP methods 
 */
trait WebService{
	 
   //Send notification to MW soap 
    public function donate()
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
            curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request); 
            curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml; charset=utf-8', 'Content-Length: '.strlen($request))); 
                      
            $result = curl_exec($soap_do);

         return ($result);
      }
      
     
} 
