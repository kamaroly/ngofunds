<?php namespace Kamaro\Donation;
use Kamaro\Contracts\SoapApi as SoapApi;
/**
 * Consuming donation webservice at https://10.138.84.110:4430/service1.asmx
 */
 class Donation extends SoapApi
 {
 	 /**
 	  * Id of the post which is receiving donation
 	  */
 	public $postid;
 	 /**
 	  * Amount to donate
 	  */
 	public $amount;
 	/**
 	 * Tigo Cash number to debit the amount ex: 250722123127 
 	 */
 	public $msisdn;
 	/**
 	 * Tigo cash pin to use for comfirming the transactions
 	 */
 	public $pin ;
  
  /**
   * Addition header separated by comma
   */
  public $addHeader='SOAPAction: "http://tempuri.org/Donations_Donate"';
  /**
   * Url to send the request to 
   */
 	public $url ='https://10.138.84.110:4430/service1.asmx?op=Donations_Donate';

 	/**
 	 * Get formatted request to send to the webservice2
 	 * @return xml string
 	 */
 	protected function getRequest()
 	 {
 	 return '<?xml version="1.0" encoding="utf-8"?>
              <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                <soap:Body>
                  <Donations_Donate xmlns="http://tempuri.org/">
                    <Postid>'.$this->postid.'</Postid>
                    <Amount>'.$this->amount.'</Amount>
                    <Msisdn>'.$this->msisdn.'</Msisdn>
                    <Pin>'.$this->pin.'</Pin>
                  </Donations_Donate>
                </soap:Body>
              </soap:Envelope>';
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
         
         // If there is no response , then something has gone wrong, return false
         return (array_sum($response))?$response:false;

      }
 } 


