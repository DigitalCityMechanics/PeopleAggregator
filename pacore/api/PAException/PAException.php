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
	    }	    
    }catch(Exception $ex){
    	// ignore this exception. No need to throw it since the HttpStatusCode is
    	// not important enough to throw over the real exception    	
    }
    
  }
}
?>