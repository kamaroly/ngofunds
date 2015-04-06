<?php namespace Kamaro\Notification;


use Kamaro\Contracts\NotificationInterface as notification;
/**
* Send SMS notification using MiddlWare SendNotification api
*/
class SendSms implements notification
{   
    use \kamaro\Traits\ResponseHandler;
	/**
	 * Who is supposed to be notified
	 * @var 
	 */
	public $destination;
    /**
     * From where notification is coming from
     * @var
     */
	protected $source ='Ngos Funds';
    /**
     * Message to be sent
     * @var
     */
    public $message;
    /**
     * Url to send request to
     */
    public $url = 'http://10.138.84.138:8002/osb/services/SendNotification_1_0';
    
    // username for the web service 
    public $username="test_mw_osb";

    //password for the webservice
    public $password="tigo1234";
   /**
     * Method to prepare xml query 
     */  
    public function getUrl()
    {
        return $this->url;
    }
   
     /**
      * @brief format tigo Rwanda MiddleWare sendNotification sms request
      * @return string
      */
      private function getRequest()
      {
   //Store your XML Request in a variable
       return '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://xmlns.tigo.com/SendNotificationRequest/V1" xmlns:v3="http://xmlns.tigo.com/RequestHeader/V3" xmlns:v2="http://xmlns.tigo.com/ParameterType/V2" xmlns:cor="http://soa.mic.co.af/coredata_1">
       <soapenv:Header xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
         <cor:debugFlag>true</cor:debugFlag>
         <wsse:Security>
            <wsse:UsernameToken>
               <wsse:Username>'.$this->username.'</wsse:Username>
               <wsse:Password>'.$this->password.'</wsse:Password>
            </wsse:UsernameToken>
         </wsse:Security>
      </soapenv:Header>
      <soapenv:Body>
         <v1:SendNotificationRequest>
            <v3:RequestHeader>
               <v3:GeneralConsumerInformation>
                     <!--Optional:-->
                  <v3:consumerID>TIGO</v3:consumerID>
               <!--Optional:-->
                  <v3:transactionID>345cyz</v3:transactionID>
               <v3:country>RWA</v3:country>
                  <v3:correlationID>1234</v3:correlationID>
               </v3:GeneralConsumerInformation>
            </v3:RequestHeader>
         <v1:RequestBody>
            <v1:channelId>SMS</v1:channelId>
            <v1:customerId>'.$this->destination.'</v1:customerId>
            <v1:message>'.$this->message.'</v1:message>
           <!--Optional:-->
            <v1:additionalParameters>
               <v2:ParameterType>
                  <v2:parameterName>smsShortCode</v2:parameterName>
                  <v2:parameterValue>'.$this->source.'</v2:parameterValue>
               </v2:ParameterType>               
            </v1:additionalParameters>            
            <v1:externalTransactionId>1234</v1:externalTransactionId>
            <!--Optional:-->
            <v1:comment>Send Notification</v1:comment>
         </v1:RequestBody>
      </v1:SendNotificationRequest>
   </soapenv:Body>
</soapenv:Envelope>';

      }

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
                  curl_setopt($soap_do, CURLOPT_USERPWD,$this->username.":".$this->password);
                  
                  $result = curl_exec($soap_do);

         $response['status']      = $this->getStringBetween($result,'<v31:status>','</v31:status>');
         $response['code']        = $this->getStringBetween($result,'<v31:code>','</v31:code>');
         $response['description'] = $this->getStringBetween($result,'<v31:description>','</v31:description>');
         return $response;
      }
}