<?php
/** !
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * UserContributionsModule.php is a part of PeopleAggregator.
 * This module is used to display the user's 'contributions' and 'thoughts' data.
 * The contributions data is returned from party web site which exposes the actual 'contributions' data.
 * The thoughts data come from PeopleAggregator
 * a REST API
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * @author [creator, or "Original Author"]
 * @license http://bit.ly/aVWqRV PayAsYouGo License
 * @copyright Copyright (c) 2010 Broadband Mechanics
 * @package PeopleAggregator
 */
?>
<?php
require_once "web/includes/classes/Pagination.php";
require_once "web/includes/classes/CurlRequestCreator.php";
require_once "api/Content/Content.php";
require_once "api/Group/Group.php";
require_once "api/Logger/Logger.php";

class UserContributionsModule extends Module {

	public $module_type = 'user|network|group';
	public $module_placement = 'middle';
	public $outer_template = 'outer_public_center_module.tpl';
	
	public $mode = self::USERMODE;
	
	const USERMODE = 0;
	const ORGMODE = 1;
	
	private $uid;
	private $_contributions;
	private $_thoughts;
	private $_numberOfPages;	

	function __construct() {
		parent::__construct();
		$this->html_block_id = 'UserContributionsModule';
		$this->_numberOfPages = 0;
	}

	public function initializeModule($request_method, $request_data)  {
		global $paging;	

		$this->title = "Contributions";
		
		if(!empty($this->shared_data['user_info'])) {
			$this->user = $this->shared_data['user_info'];
			$this->uid = $this->user->user_id;
			$this->mode = self::USERMODE;
		}else if(!empty($this->shared_data['group_info'])){
			$this->group = $this->shared_data['group_info'];
			$this->uid = $this->group->owner_id;
			$this->mode = self::ORGMODE;
		} else {
			return 'skip';
		}
	}

	function render() {
		global $login_uid, $page_uid;
		$content = null;
		$totalContributions = -1;
		$contributionsPerPage = 6; // contributions to show per page
		if(isset($_GET['page']) && !empty($_GET['page'])){
			$currentPage = $_GET['page'];	
			if(!is_numeric($currentPage)){
				$currentPage = 1;
			}					
		}else{
			$currentPage = 1;
		}
		
		if($this->mode == self::USERMODE){
			$contributionsArray = $this->get_contributions_data($this->uid,$contributionsPerPage, $currentPage);

			if(isset($contributionsArray) && isset($contributionsArray[0]['total']) && isset($contributionsArray[0]['contributions'])){
				$totalContributions = $contributionsArray[0]['total'];
				$contributionsList = $contributionsArray[0]['contributions'];
			}else if(isset($contributionsArray) && isset($contributionsArray['total']) && isset($contributionsArray['contributions'])){
				$totalContributions = $contributionsArray['total'];
				if($totalContributions > 0){
					$contributionsList = $contributionsArray['contributions'];
				}else{
					$contributionsList = $contributionsArray;
				}		
			}else if(isset($contributionsArray['contributions']) && !empty($contributionsArray['contributions'])){
				$contributionsList = $contributionsArray['contributions'];
			}else{
				$contributionsList = $contributionsArray;
			}
			$this->_contributions = $contributionsList;

			if($totalContributions > 0){
				$this->_numberOfPages = $totalContributions/$contributionsPerPage;				
				$this->_numberOfPages = (int)ceil($this->_numberOfPages);				
			}
			
			
				
		    $Pagination = new Pagination;
		    $pagingSettings["page"] = $currentPage;   
		    $pagingSettings["show"] = $contributionsPerPage;
		    $pagingSettings["count"] = $totalContributions;
		    $Pagination->setPaging($pagingSettings);
		    $this->page_links = $Pagination->getPageLinks();
				
		}else if($this->mode == self::ORGMODE){
			$this->_contributions = array();
		}

		$this->inner_HTML = $this->generate_inner_html();
		$content = parent::render();

		return $content;
	}


	function generate_inner_html () {

		$tmp_file = PA::$blockmodule_path .'/'. get_class($this) . '/center_inner_public.tpl';

		$inner_html_gen = new Template($tmp_file);
		$inner_html_gen->set('contributions', $this->_contributions);	
		$inner_html_gen->set('page_links', $this->page_links);
		
		$inner_html_gen->set('mode', $this->mode);
		$inner_html_gen->set('USERMODE', self::USERMODE);
		$inner_html_gen->set('ORGMODE', self::ORGMODE);
		$inner_html_gen->set('is_my_profile', isset($this->shared_data['is_my_profile']) ? $this->shared_data['is_my_profile'] : false);
		
		$inner_html = $inner_html_gen->fetch();
		return $inner_html;
	}

	/**
	 * Get contributions data for the given user and the number of contributions to return and the requested page for paging
	 * @param int $User_id
	 * @param int $ContributionsPerPage
	 * @param int $RequestedPage
	 * @return an associative array of the response data. If no data is present or there is an error, no data is returned
	 */
	function get_contributions_data($User_id, $ContributionsPerPage, $RequestedPage){
		//TODO: throw exceptions and check for bad error codes
		//TODO: put URL in App_Config.xml
		// TEMPORARY TEST CODE, REMOVE LATER
		if(isset($_GET['testuser'])){
			$User_id = $_GET['testuser'];
		}
		if(isset($User_id)){
			$url = $this->buildRESTAPIUrl(CC_APPLICATION_URL, CC_APPLICATION_URL_TO_API, CC_ROUTE_CONTRIBUTIONS, $User_id);
			//$url = "http://www.peeps.com/contributions.html";
			$url = $url . "?per_page=" . $ContributionsPerPage . "&page=" . $RequestedPage;
			$request = new CurlRequestCreator($url, true, 30, 4, false, true, false);
			$empty_message = 'You are not participating in any conversations or issues yet: ';
			$empty_message .= (isset(PA::$page_user) && isset(PA::$page_user->display_name))
				? PA::$page_user->display_name.' is just getting started.'
				: 'You seem to be just getting started.';
			$defaultResult = array('default'=>true, 'parent_title'=>null, 'parent_url'=> CC_APPLICATION_URL . CC_ROUTE_CONVERSATIONS, 'created_at'=> null, 'content' => $empty_message, 'attachment_url' => null, 'embed_code' => null, 'type' => null, 'link_text' => null, 'link_url' => null);
			$responseStatus = $request->createCurl();

			if($responseStatus == 200){
				$jsonResults = $request->getJSONResponse();
				if(count($jsonResults) == 0){
					$jsonResults[] = $defaultResult;
				}else if($jsonResults['total'] == 0){
					$jsonResults[] = $defaultResult;
				}
				return $jsonResults;
			}else{
    			Logger::log("UserContributionsModule.get_contributions_data() could not get data from the cURL request. URL: $url | HTTP Response Status: $responseStatus", LOGGER_WARNING);				
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
		$url = $SiteURL . $APILink . $ObjectIdentifier . $ObjectType;
		return $url;
	}
}
?>
