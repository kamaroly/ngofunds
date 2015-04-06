<?php namespace Kamaro\Validators;

use Kamaro\Contracts\SoapApi as SoapApi;
/**
* Verify the pin of the MFS
*/
class MfsCheckPin extends SoapApi
{
		 /**
      * @brief format tigo Rwanda MiddleWare sendNotification sms request
      * @return string
      */
      protected function getRequest()
      {
   //Store your XML Request in a variable
       return '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <TigoCash_Check_Pin_MFI xmlns="http://tempuri.org/">
      <Subscriber>250722123127</Subscriber>
      <userPin>0000</userPin>
      <Mfinumber>string</Mfinumber>
      <MfiPin>string</MfiPin>
      <Source>string</Source>
    </TigoCash_Check_Pin_MFI>
  </soap:Body>
</soap:Envelope>';

      }

}