<?php
/** !
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * UserFollowingIssuesModule.php is a part of PeopleAggregator.
 * This module is used to display 'issues' that the user is 'following'. The data is read from a
 * third party web site which exposes the actual 'conversations', and 'following' data in
 * a REST API
 *
 * 10/31/10	Parag Jagdale	Created Initial Module
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * @author Tom Dooner
 * @license http://bit.ly/aVWqRV PayAsYouGo License
 * @copyright Copyright (c) 2010 Broadband Mechanics
 * @package PeopleAggregator
 */
?>
<?php

require_once "web/includes/classes/CurlRequestCreator.php";
require_once "api/Logger/Logger.php";

class UserFollowingIssuesModule extends Module {

	public $module_type = 'user|group'; 
	public $module_placement = 'left|right';
	public $outer_template = 'outer_public_side_module.tpl';
	public $per_option;
	
	private $uid;
	private $_conversations;
	private $_issues;
	private $_following;

	function __construct() {
		parent::__construct();
		$this->html_block_id = 'UserFollowingIssuesModule';
	}


	public function initializeModule($request_method, $request_data)  {
		global $paging;

		$this->title = "Issues I am Following";

		if(!empty($this->shared_data['user_info'])) {
			$this->user = $this->shared_data['user_info'];
			$this->uid = $this->user->user_id;
		}else if(!empty($this->shared_data['group_info'])){
			$this->group = $this->shared_data['group_info'];
			$this->uid = $this->group->owner_id;
		} else {
			return 'skip';
		}
	}


	function render() {
		global $login_uid, $page_uid;
		$content = null;
		$this->_issues = $this->get_issues_data($this->uid);
		$this->inner_HTML = $this->generate_inner_html ();
		$content = parent::render();

		return $content;
	}

	function generate_inner_html () {

		$tmp_file = PA::$blockmodule_path .'/'. get_class($this) . '/side_inner_public.tpl';

		$inner_html_gen = new Template($tmp_file);
		$inner_html_gen->set('issues', $this->_issues);

		$inner_html = $inner_html_gen->fetch();
		return $inner_html;
	}

	
	/**
	 * Get issues data.
	 * @param 	$User_id
	 * @return	an associative array of the response data. If no data is present or there is an error, no data is returned
	 */
	function get_issues_data($User_id){
		//TODO: throw exceptions and check for bad error codes
		//TODO: put URL in App_Config.xml
		// TEMPORARY TEST CODE, REMOVE LATER
		if(isset($_GET['testuser'])){
			$User_id = $_GET['testuser'];
		}
		if(isset($User_id)){
			$url = $this->buildRESTAPIUrl(CC_APPLICATION_URL, CC_APPLICATION_URL_TO_API, CC_ROUTE_ISSUES, $User_id);
			$request = new CurlRequestCreator($url, true, 30, 4, false, true, false);
			$responseStatus = $request->createCurl();
			$defaultResult = array('name'=>'No issues followed yet', 'url' => '#');
			if($responseStatus == 200){
				$jsonResults = $request->getJSONResponse();
				if(count($jsonResults) == 0){
					$jsonResults[] = $defaultResult;
				}			
				return $jsonResults;
			}else{
				Logger::log("UserFollowingIssuesModule.get_issues_data() could not get data from the cURL request. URL: $url | HTTP Response Status: $responseStatus", LOGGER_WARNING);
				return array($defaultResult);
			}
		}
		return null;
	}

	
	/**
	 * Creates a URL from the given parts into a usable REST URL
	 * Note: this function is customized for the CivicCommons project URLs (ie. http://www.example.com/$APIFolder/$ObjectIdentifier/$ObjectType
	 * @param string $SiteURL				Base Site URL to the REST API (ie. http://www.example.com)
	 * @param string $APIFolder				The folder that lets the web site know that the API is being called (ie. http://www.example.com/api) 
	 * @param string $ObjectType			The type of object to get (ie. to get conversations, append a api/conversations to the end to get the objects of that type)
	 * @param string $ObjectIdentifier		The identifier of the specific object to get
	 */
	function buildRESTAPIUrl($SiteURL, $APILink, $ObjectType, $ObjectIdentifier){
		//TODO: add ability to remove double slashes
		$url = $SiteURL . $APILink . "/" . $ObjectIdentifier . $ObjectType;
		return $url;
	}
	
}
?>
