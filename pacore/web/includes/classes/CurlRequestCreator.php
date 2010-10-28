<?php
/** !
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * CurlRequestCreator.php is a part of PeopleAggregator.
 * This class was first copied from the comments on http://php.net/manual/en/book.curl.php
 * It is used to create cURL requests to external APIs
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * @author Parag Jagdale
 * @license http://bit.ly/aVWqRV PayAsYouGo License
 * @copyright Copyright (c) 2010 Broadband Mechanics
 * @package PeopleAggregator
 */

/**
 * Usage:
 $request = new CurlRequestCreator("http://www.othersite.com/exposed_REST_api", true, 30, 4, false, true, false);
 $request->setGet(array("var1"=>"value1", "var2"=>"value2"));
 $request->createCurl();
 $jsonResponseData = $request->getJSONResponse();
 */
?>
<?php
class CurlRequestCreator {
	protected $_useragent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1';
	protected $_url;
	protected $_followlocation;
	protected $_timeout;
	protected $_maxRedirects;
	protected $_cookieFileLocation = './cookie.txt';
	protected $_post;
	protected $_postFields;
	protected $_get;
	protected $_getFields;
	protected $_referer ="http://www.google.com";

	protected $_session;
	protected $_includeHeader;
	protected $_noBody;
	protected $_status;
	protected $_binaryTransfer;
	public    $authentication = 0;
	public    $auth_name      = '';
	public    $auth_pass      = '';

	protected $_response;
	private $response_meta_info;
	private $response_header_array;
	private $_body;
	private $_header;

	private $debugMode = false;

	/**
	 * returns response http status
	 */
	public function getHttpStatus()
	{
		return $this->_status;
	}

	/**
	 * Returns response header only.
	 */
	public function getResponseHeader(){
		return $this->_header;
	}

	/**
	 * Returns response body only.
	 */
	public function getResponseBody(){
		return $this->_body;
	}


	public function useAuth($use){
		$this->authentication = 0;
		if($use == true) $this->authentication = 1;
	}

	public function setName($name){
		$this->auth_name = $name;
	}
	public function setPass($pass){
		$this->auth_pass = $pass;
	}

	/**
	 * Constructor
	 * @param unknown_type $url
	 * @param unknown_type $followlocation
	 * @param unknown_type $timeOut
	 * @param unknown_type $maxRedirecs
	 * @param unknown_type $binaryTransfer
	 * @param unknown_type $includeHeader
	 * @param unknown_type $noBody
	 */
	public function __construct($url,$followlocation = true,$timeOut = 30,$maxRedirecs = 4,$binaryTransfer = false,$includeHeader = false,$noBody = false)
	{
		$this->_url = $url;
		$this->_followlocation = $followlocation;
		$this->_timeout = $timeOut;
		$this->_maxRedirects = $maxRedirecs;
		$this->_noBody = $noBody;
		$this->_includeHeader = $includeHeader;
		$this->_binaryTransfer = $binaryTransfer;

		$this->_cookieFileLocation = dirname(__FILE__).'/cookie.txt';

	}

	public function setReferer($referer){
		$this->_referer = $referer;
	}

	public function setCookiFileLocation($path)
	{
		$this->_cookieFileLocation = $path;
	}

	/**
	 * Sets the post variables to send in the request
	 * @param Array $postFields
	 */
	public function setPost ($postFields)
	{
		$this->_post = true;
		$this->_postFields = $postFields;
	}

	/**
	 * Sets the get variables to send in the request
	 * @param Array $getFields
	 */
	public function setGet ($getFields)
	{
		$this->_get = true;
		// PHP5 required
		$this->_getFields = http_build_query($getFields);
	}

	public function setUserAgent($userAgent)
	{
		$this->_useragent = $userAgent;
	}

	public function createCurl($url = null)
	{
		if($url != null){
			$this->_url = $url;
		}

		$s = curl_init();

		if(DEBUG) {
			curl_setopt($s,CURLOPT_VERBOSE,1);
		} else {
			curl_setopt($s,CURLOPT_VERBOSE,0);
		}
		curl_setopt($s,CURLOPT_URL,$this->_url);
		curl_setopt($s,CURLOPT_HTTPHEADER,array('Expect:'));
		curl_setopt($s,CURLOPT_TIMEOUT,$this->_timeout);
		curl_setopt($s,CURLOPT_MAXREDIRS,$this->_maxRedirects);
		curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($s,CURLOPT_FOLLOWLOCATION,$this->_followlocation);
		curl_setopt($s,CURLOPT_COOKIEJAR,$this->_cookieFileLocation);
		curl_setopt($s,CURLOPT_COOKIEFILE,$this->_cookieFileLocation);
		/*
		 //register a callback function which will process the headers
		 //this assumes your code is into a class method, and uses $this->readHeader as the callback //function
		 curl_setopt($s, CURLOPT_WRITEFUNCTION, array(&$this,'readHeader'));
		 */
		if($this->authentication == 1){
			curl_setopt($s, CURLOPT_USERPWD, $this->auth_name.':'.$this->auth_pass);
		}
		if($this->_post)
		{
			curl_setopt($s,CURLOPT_POST,1);
			curl_setopt($s,CURLOPT_POSTFIELDS,$this->_postFields);
		}

		if($this->_get){
			$parsedURL = parse_url($this->_url);
			//TODO: this doesnt account for fragments ('#')
			if(isset($parsedURL["query"])){
				// there are already some GET variables in the URL, so append new ones afterward
				$this->_url = $this->_url . '&' . $this->_getFields;
			}else{
				// there are no GET variables in the URL
				$this->_url = $this->_url . '?' . $this->_getFields;
			}
		}

		if($this->_includeHeader)
		{
			curl_setopt($s,CURLOPT_HEADER,true);
		}

		if($this->_noBody)
		{
			curl_setopt($s,CURLOPT_NOBODY,true);
		}
		/*
		 if($this->_binary)
		 {
		 curl_setopt($s,CURLOPT_BINARYTRANSFER,true);
		 }
		 */
		curl_setopt($s,CURLOPT_USERAGENT,$this->_useragent);
		curl_setopt($s,CURLOPT_REFERER,$this->_referer);
		try{

			$this->_response = curl_exec($s);
			$this->_status = curl_getinfo($s,CURLINFO_HTTP_CODE);

			list($this->_header, $this->_body) = explode("\r\n\r\n", $this->_response, 2);

			//get the default response headers
			$this->response_header_array = curl_getinfo($s);

			if($this->debugMode == true){
				print "<pre>\n";
				print_r($this->response_header_array);  // get error info
				echo "\n\ncURL error number:" .curl_errno($s); // print error info
				echo "\n\ncURL error:" . curl_error($s);
				print "</pre>\n";
			}

			curl_close($s); // close curl session
		}catch(Exception $ex){
			throw $ex;
		}
		return $this->_status;
	}



	/**
	 * CURL callback function for reading and processing headers
	 * Override this for your needs
	 *
	 * @param object $ch
	 * @param string $header
	 * @return integer
	 */
	private function readHeader($ch, $header) {
		//extracting example data: filename from header field Content-Disposition
		$filename = $this->extractCustomHeader('Content-Disposition: attachment; filename=', '\n', $header);
		if ($filename) {
			$this->response_meta_info['content_disposition'] = trim($filename);
		}
		$this->response_header_array[] =  $header;

		return strlen($header);
	}

	private function extractCustomHeader($start,$end,$header) {
		$pattern = '/'. $start .'(.*?)'. $end .'/';
		if (preg_match($pattern, $header, $result)) {
			return $result[1];
		} else {
			return false;
		}
	}

	function getHeaders() {
		return $this->response_header_array;
	}

	public function __tostring(){
		return $this->_response;
	}

	/**
	 * Returns an associative array of the JSON response
	 */
	public function getJSONResponse(){
		if(isset($this->_body)){
			return json_decode($this->_body, true);
		}else{
			return false;
		}
	}
}
?>