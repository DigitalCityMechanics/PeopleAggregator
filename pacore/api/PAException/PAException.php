<?php
/** !
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* [filename] is a part of PeopleAggregator.
* [description including history]
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @author [creator, or "Original Author"]
* @license http://bit.ly/aVWqRV PayAsYouGo License
* @copyright Copyright (c) 2010 Broadband Mechanics
* @package PeopleAggregator
*/
?>
<?php
require_once 'PAExceptionCodes.inc';
require_once "ext/php-hoptoad-notifier/Services/Hoptoad.php";
/**
* Class PAException extends the base exception class for the PeopleAggregator
*
* @package PAException
* @author Gaurav Bhatnagar
*/
class PAException extends Exception {
  public $code;
  public $message;
  public function __construct ($exceptionCode, $exceptionMessage) {
    parent::__construct($exceptionMessage, (int)$exceptionCode);
    $this->code = $exceptionCode;
    $this->message = $exceptionMessage;
    
    try{
	    // Gets the matching HTTP Status code for the exception code
	    list($code_string, $httpStatusCode) = pa_get_error_name($this->code);
	    if(isset($httpStatusCode)){
		    // set http header error code
	    	header(HttpStatusCodes::httpHeaderFor($httpStatusCode));

			// log the occrance in php error log
			//user_error(print_r($httpStatusCode, true), E_USER_WARNING);
	    }
    }catch(Exception $ex){
    	// ignore this exception. No need to throw it since the HttpStatusCode is
    	// not important enough to throw over the real exception    	
    }
    
    try{
    	$hoptoad = new Services_Hoptoad("b16b886469e9c1f3dccfdbb11e56123f", 'staging', 'curl');
    	$hoptoad->exceptionHandler($this);
    }
    catch(Exception $e){
		// ignore exception since posting to Hoptoad is not fatal    	
    }
    
    
  }
}
?>