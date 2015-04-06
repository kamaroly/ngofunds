<?php namespace kamaro\Traits;

trait ResponseHandler{

/**
 * Take XML content and convert
 * if to a PHP array.
 * @param string $xml Raw XML data.
 * @param string $main_heading If there is a primary heading within the XML that you only want the array for.
 * @return array XML data in array format.
 */
public function xmlToArray($xml,$main_heading = '') 
  {
    $deXml = simplexml_load_string($xml);
    $deJson = json_encode($deXml);
    $xmlArray = json_decode($deJson,TRUE);
    
    //Do we have some special section to care about?
    if (! empty($main_heading)) 
    {
        $returned = $xmlArray[$main_heading];
        return $returned;
    } 
        
   return $xmlArray;
  }

 /**
 * Get a string between two words
 * if to a PHP array.
 * @param string $string to search in.
 * @param start first string to start extraction with
 * @param end last string to stop at
 * @return array XML data in array format.
 */
  public function getStringBetween($string, $start, $end)
  {
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
   return substr($string,$ini,$len);
 }

public static function imageBinary($filepath)
  {
      $out = null;
      //Try to open image file
      $handle = @fopen($filepath, 'rb');
      // if the file is opened let's try to read file bits
      if ($handle)
      {   
          $content = @fread($handle, filesize($filepath));

          // convert file bits to hex 
          $content = bin2hex($content);  
          @fclose($handle);
     return    $out = "0x".$content;
      }

      return false;
  }
    
}