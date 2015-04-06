<?php namespace Kamaro\Contracts;
/**
* Parent class for all the soap request classes
* @author Kamaro Lambert
* @email  kamaroly@gmail.com
*/
class SoapApi{
    
    /**
     * Import common methods to use
     */
    use \kamaro\Traits\ResponseHandler;
    
    /**
     * Url to use when consuming the API 
     */
 	  public $url;
 	 /**
 	  * Content type to send in the header of the request
 	  */
    public $contentType  ='text/xml; charset=utf-8';
    /**
     * Content length to send in the header of the request
     */
    public $contentLength ='length';
    /**
     * Array that containts addional headers to be send in the request
     */

    /////////////////////////////////////////////////////////////////////////////////////
    //                            ADDITIONAL HEADERS ARRAY FORMAT                      //
    // --------------------------------------------------------------------------------//
    // $additionHeaders= [                                                             //
    //                     'SOAPAction: "http://tempuri.org/TigoCash_Check_Pin_MFI"',  //                          //
    //                     'SOAPAction: "http://tempuri.org/Donations_Donate"',        //
    //                     'SOAPAction: "http://tempuri.org/TigoCash_ResetPin"'        //
    //                   ];                                                            //
    /////////////////////////////////////////////////////////////////////////////////////
     
    public $additionHeaders = [];  
     

     /**
 	 * @brief Consume Soap ui 
 	 * @return mixed
 	 */
    public function request()
     {
        $request  = $this->getRequest();
        
        $this->contentLength = strlen($request);

        $headers  = array('Content-Type:'.$this->contentType, 
            	            'Content-Length:'.$this->contentLength
            	         );  
         
           $soap_do = curl_init(); 
           curl_setopt($soap_do, CURLOPT_URL,            $this->url );   
           curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10); 
           curl_setopt($soap_do, CURLOPT_TIMEOUT,        10); 
           curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
           curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);  
           curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
           curl_setopt($soap_do, CURLOPT_POST,           true ); 
           curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request); 
           curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $headers );               
           $result = curl_exec($soap_do);

        return  $this->cleanResponse($result);;
      }
    
     /**
       * Clean the soap ui response
       * @param response xml soap response
       * @return  array
       */
      protected function cleanResponse($result)
      {  
         $response['PostId'] = $this->getStringBetween($result,'<PostId>','</PostId>');
         $response['Description']      = $this->getStringBetween($result,'<Description>','</Description>');
         $response['Details'] = $this->getStringBetween($result,'<Details>','</Details>');
         $response['Status']        = $this->getStringBetween($result,'<Status>','</Status>');
         $response['TotalViews'] = $this->getStringBetween($result,'<TotalViews>','</TotalViews>');
         $response['TotalDonations'] = $this->getStringBetween($result,'<TotalDonations>','</TotalDonations>');
         $response['Picture'] = $this->getStringBetween($result,'<Picture>','</Picture>');
         
         return $response;

      }
}