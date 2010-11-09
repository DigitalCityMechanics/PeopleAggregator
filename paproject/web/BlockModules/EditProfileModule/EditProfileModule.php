<?php
/** !
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * EditProfileModule.php is a part of PeopleAggregator.
 * This file manages the various edit pages in a user's profile.
 *  The different types of profile (basic, general, personal, etc) are all here,
 *  and there are separate functions below to handle their data.
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * @author Martin Spernau?
 * @license http://bit.ly/aVWqRV PayAsYouGo License
 * @copyright Copyright (c) 2010 Broadband Mechanics
 * @package PeopleAggregator
 */
?>
<?php
require_once "web/includes/classes/CurlRequestCreator.php";
require_once 'ext/Zend/Exception.php';
require_once 'ext/Zend/Form.php';
require_once 'ext/Zend/Form/Element/File.php';
require_once 'ext/Zend/File/Transfer/Adapter/Http.php';
require_once 'ext/Zend/File/Transfer/Exception.php';
require_once 'ext/Zend/Service/Amazon/S3.php';
require_once 'ext/Zend/Validate/PostCode.php';
require_once 'ext/Zend/Validate/StringLength.php';
require_once 'ext/PHPThumb/src/ThumbLib.inc.php';
require_once 'web/includes/classes/file_uploader.php';
require_once PA::$blockmodule_path.'/EditProfileModule/DynamicProfile.php';

class EditProfileModule extends Module {

	public $module_type = 'user';
	public $module_placement = 'middle';
	public $outer_template = 'outer_public_center_edit_profile_module.tpl';
	public $blogsetting_status;

	//All the valid profile types. If we have to add new profile type, then profile type should be entered here also.
	public $valid_profile_types = array('basic', 'general', 'personal', 'professional', 'notifications', 'delete_account');

	//Profile type currently under view
	public $profile_type;

	//User profile information for the particular section or type under view.
	public $section_info;

	//User id of the user who is editing the profile information.
	//By Default it will be login uid which will be set in constructor, but can be set from outside of this
	//class like for the cases where user having role of editing other's profile.
	public $uid;

	//User object having the user information
	public $user_info;

	private $_image_sizes = array(
								    'original'  => null,
									'large' 	=> array('width' => 185, 'height' => 185),
									'standard' 	=> array('width' => 70,  'height' => 70),
									'medium' 	=> array('width' => 40,  'height' => 40),
									'small' 	=> array('width' => 20,  'height' => 20),									
	);

	function __construct() {
			
		parent::__construct();
		$this->main_block_id = "mod_edit_profile";
		$this->block_type = 'EditProfile';

		if (empty(PA::$config->simple['omit_advacedprofile'])) {
			//This is not simple PA. Add the advanced profile types to valid types.
			array_push($this->valid_profile_types, 'export');
		}
		//by default basic profile will be shown
		$this->profile_type = 'basic';
		$this->uid = PA::$login_uid;
		$this->user_info = PA::$login_user;

		// if a userID is specified and the logged in user can manage the network, let them edit
		if(isset($_GET) && isset($_GET['uid']) && PermissionsHandler::can_user(PA::$login_uid, array('permissions' => 'manage_settings'))) {
			$this->uid = intval($_GET['uid']);
			$this->user_info = new User();
			$this->user_info->load($this->uid);
		}
	}
	/** !!
	 * Initalizes some things, shuffles data from $request_data to $this
	 * @param array $request_method Provided method of data submission.
	 * @param array $request_data POST/GET data. In here must be ['type'], which is like (basic, genera$
	 */
	public function initializeModule($request_method, $request_data) {
		if (empty($this->uid)) return 'skip';

		if (!empty($request_data['type']) && in_array($request_data['type'], $this->valid_profile_types)) {
			$this->profile_type = $request_data['type'];
		}
		// Load data for the requested section
		$givenSectionData = $this->loadSection($this->profile_type, $this->uid);
		$givenSectionDataSanitized = $this->santitizeSectionInfo($givenSectionData);

		// Load and add GENERAL section data
		$generalSectionData = $this->loadSection('general', $this->uid);
		$generalSectionDataSanitized = $this->santitizeSectionInfo($generalSectionData);
		// Merge requested section data and general section data
		$this->section_info = array_merge($givenSectionDataSanitized, $generalSectionDataSanitized);
		$this->request_data = $request_data;
	}
	/** !!
	 * Invokes {@see load_user_profile()} to load the current user profile.
	 * @param string $profile_type Must be one of the profile types (Basic, general, etc.)
	 * @param int $user_id The ID of the user of which to fetch the profile.
	 * @return array User profile as loaded by {@see load_user_profile()}
	 */
	public function loadSection($profile_type, $user_id) {
		$section = NULL;
		switch ($profile_type) {
			case 'basic':
				$section = BASIC;
				break;
			case 'general':
				$section = GENERAL;
				break;
			case 'personal':
				$section = PERSONAL;
				break;
			case 'professional':
				$section = PROFESSIONAL;
				break;
		}
		return (!is_null($section)) ? User::load_user_profile($user_id, $user_id, $section) : FALSE;
	}
	/** !!
	 * Returns a new section_info which has the old section_info
	 * as well as permission data.
	 * @param array $section_info Collection like [0]=>array(['name']=>'',['value']=>mixed,['perm']=>'')
	 * @return array Collection like [0]=>array($name=>value,$name."_perm"=>$perm)
	 */
	public function santitizeSectionInfo($section_info) {
		$sanitized_section_info = array();
		$count = count($section_info);
		for ($counter = 0; $counter < $count; $counter++) {
			$field_name = $section_info[$counter]['name'];
			$field_value = $section_info[$counter]['value'];
			$permission_name = $field_name."_perm";
			$permission_value = $section_info[$counter]['perm'];
			$sanitized_section_info[$field_name] = $field_value;
			$sanitized_section_info[$permission_name] = $permission_value;
		}
		return $sanitized_section_info;
	}
	/** !!
	 * Upon post, this method calls a method defined later in this file,
	 *  one with a name like {$section_name}ProfileSave, where $section_name
	 *  is basic,general,professional,etc.
	 * @param string $request_method Should be POST.
	 * @param array $request_data Profile data to save. Will be passed to its respective method.
	 */
	public function handleSaveProfile($request_method, $request_data) {
		global $error_msg;

		$error_msg = null;
		switch ($request_method) {
			case 'POST':
				filter_all_post(&$request_data);
				if (!empty($request_data['profile_type'])) {
					$saveHandler = $request_data['profile_type'].'ProfileSave';
					if (method_exists($this, $saveHandler)) {
						$this->$saveHandler($request_data);
					} else {
						$error_msg = __("EditProfileModule::handleSaveProfile() - Unknown save handler!");
					}
				}
				break;
		}
		//    $this->setWebPageMessage();
	}
	/** !!
	 ************************************************************************
	 * The following methods take the request data, validate it, parse it,
	 * and store it if there were no previous errors.
	 ************************************************************************
	 */
	public function basicProfileSave($request_data) {
		global $error_msg;
		$thumb = null;
		$file_name = null;
		$file_mime_type = null;
		$file_size = null;
		$apiDataArray = array('person'=>null);

		$this->isError = TRUE;
		if (empty($request_data['first_name'])) {
			$this->message = __('Fields marked with * can not be empty, First name can not be empty.');
		} else if (empty($request_data['email_address'])) {
			$this->message = __('Fields marked with * can not be empty, Email field is mandatory.');
		} else if (!empty($request_data['pass']) || !empty($request_data['conpass'])) {
			$set_new_password = true;
			$new_password_ok = false;
			if ($request_data['pass'] != $request_data['conpass']) {
				$this->message = __('Password and confirm password should match.');
			} else if (strlen($request_data['pass']) < PA::$password_min_length) {
				$this->message = sprintf(__('Password should be of %s characters or more.'), PA::$password_min_length);
			} else if (strlen($request_data['pass']) > PA::$password_max_length) {
				$this->message = sprintf(__('Password should be less than %s charcaters.'), PA::$password_max_length);
			} else {
				// all is good
				$new_password_ok = true;
			}
		}

		if(isset($request_data['postal_code']) && isset($request_data['postal_code']['value']) && !empty($request_data['postal_code']['value'])){
			$zipCode = trim($request_data['postal_code']['value']);

			$validator = new Zend_Validate_PostCode("en_US");
			if (!$validator->isValid($zipCode)) {
				$this->message = "The zip code is invalid.";
			}else{
				$request_data['postal_code']['value'] = $zipCode;
				$apiDataArray['person']['zip_code'] = $zipCode;
			}
		}

		if(isset($request_data['about']) && isset($request_data['about']['value']) && !empty($request_data['about']['value'])){
			$about = trim($request_data['about']['value']);
			$validator = new Zend_Validate_StringLength(array('max'=>500));
			if (!$validator->isValid($about)) {
				$this->message = "The about field is limited to 500 characters. There are " . strlen($about) . " characters in the about field";
			}
		}

		if ($request_data['deletepicture'] == "true") {
			$this->handleDeleteUserPic($request_data);
		}

		/* Parag Jagdale - 10/27/2010: Upload files with Zend library, Resize files and upload to AmazonS3 */
		if (empty($this->message) && !empty($_FILES['userfile']['name'])) {
			$file = null;

			// Recieve uploaded file
			$zendUploadAdapter = new Zend_File_Transfer_Adapter_Http();
			$zendUploadAdapter->setDestination(PA::$upload_path);
			$zendUploadAdapter->addValidator('Size', false, '1MB')
			->addValidator('Count', false, 1)
			->addValidator('FilesSize', false, array('min' => '1kB','max' => '2MB'))
			->addValidator('Extension', false, array('jpeg', 'jpg', 'png', 'gif'))
			->addValidator('ImageSize', false, array('minwidth' => 40,'maxwidth' => 1024, 'minheight' => 40, 'maxheight' => 768));

			if (!$zendUploadAdapter->isValid()) {
				// Invalid image, so show errors
				$this->message = __("The image you selected as your photo has some errors: <br />" . implode("<br />", $zendUploadAdapter->getMessages()));
			}

			try{
				$zendUploadAdapter->receive();
			}catch (Zend_File_Transfer_Exception $e){
				$this->message = $e->getMessage();
			}

			if (empty($this->message)) {//If there is no error message then try saving to amazon s3
				// save images to amazon s3
				global $app;
				$aws_key = null;
				$aws_secret_key = null;
				$aws_key = $app->configData['configuration']['api_keys']['value']['amazon_aws_key']['value'];
				$aws_secret_key = $app->configData['configuration']['api_keys']['value']['amazon_aws_secret']['value'];

				if(isset($aws_key) && isset($aws_secret_key)){
					$s3 = null;
					$bucketAvailable = false;
					$bucketCreated = false;
					$s3 = new Zend_Service_Amazon_S3($aws_key, $aws_secret_key);

					if(isset($s3)){

						$bucketCreated = false;
						$bucketAvailable = $s3->isBucketAvailable(AMAZON_BUCKET_NAME);

						if(!$bucketAvailable){
							if($s3->createBucket(AMAZON_BUCKET_NAME)){
								// new bucket was created
								$bucketCreated = true;
							}
						}else{
							$bucketCreated = true;
						}

						if($bucketCreated == true){

							$file_path = $zendUploadAdapter->getFileName('userfile', true);
							$file_name = $zendUploadAdapter->getFileName('userfile', false);
							$file_size = $zendUploadAdapter->getFileSize('userfile');

							$file_info = getimagesize($file_path);

							$file_mime_type = (isset($file_info) && isset($file_info['mime']) && !empty($file_info['mime'])) ? $file_info['mime'] : null;

							$apiDataArray['person'] = array(
														'avatar' => array(
																	'file_name' => $file_name,
																	'content_type' => $file_mime_type,
																	'file_size' => $file_size
							)
							);

							// api_call needs to be set to true in order for the User class to update the avatar and avatar_small fields
							$this->user_info->api_call = true;
							foreach($this->_image_sizes as $imageSizeType => $imageDimensions){
								// Resize image into thumbnails
								$imageAsString = null;
								try
								{
									$thumb = PhpThumbFactory::create($file_path);
									if(!isset($this->user_info->core_id) && !empty($this->user_info->core_id)){
										$this->user_info->core_id = 0;
									}
									$objectPath = $this->buildAmazonS3ObjectURL(AMAZON_BUCKET_NAME, $imageSizeType, $this->user_info->core_id, $file_name);
									if(isset($imageDimensions) && !empty($imageDimensions)){
										// if this is an original size image, the width and height dont need to be set
										$thumb->adaptiveResize($imageDimensions['width'], $imageDimensions['height']);
									}
									$imageAsString = $thumb->getImageAsString();
									$amazonURL = "http://s3.amazonaws.com/";
									switch($imageSizeType){
										case "large":
											$this->user_info->picture =  $amazonURL . $objectPath;
											$this->user_info->picture_dimensions = $imageDimensions;
											break;
										case "standard":
											$this->user_info->avatar =  $amazonURL . $objectPath;
											$this->user_info->avatar_dimensions = $imageDimensions;
											break;
										case "medium":
											$this->user_info->avatar_small =  $amazonURL . $objectPath;
											$this->user_info->avatar_small_dimensions = $imageDimensions;
											break;
										default:
											break;
									}
								}
								catch (Exception $e)
								{
									$this->message = $e->getMessage();
									break;
								}

								if(isset($imageAsString) && !empty($imageAsString)){
									// send object to AmazonS3
									$s3->putObject($objectPath, $imageAsString, array(Zend_Service_Amazon_S3::S3_ACL_HEADER =>Zend_Service_Amazon_S3::S3_ACL_PUBLIC_READ));
								}
							}
						}
					}
				}
			}
		}

		if (empty($this->message)) {

			// Add first name and last name if they have been changed to the api update data array
			if($this->user_info->first_name != $request_data['first_name'] || $this->user_info->last_name != $request_data['last_name']){
				$apiDataArray['person']['name'] = $request_data['first_name'] . ' ' . $request_data['last_name'];
			}

			// Add email address to api data update array only if it was chagned
			if($this->user_info->email != $request_data['email_address']){
				$apiDataArray['person']['email'] = $request_data['email_address'];
			}

			//If there is no error message then try saving the user information.
			$this->user_info->first_name = $request_data['first_name'];
			$this->user_info->last_name = $request_data['last_name'];
			$this->user_info->email = $request_data['email_address'];
				
			try{
				if (!empty($request_data['pass'])){
					$passwordSaltArray = $this->EncryptPassword($request_data['pass']);
					if(isset($passwordSaltArray)){
						list($encryptedPassword, $salt) = $passwordSaltArray;
						$this->user_info->password = $encryptedPassword;
						$apiDataArray['person']['encrypted_password'] = $encryptedPassword;
						// remove last $ from salt because ruby doesn't like it
						$salt = rtrim($salt,'$');
						$apiDataArray['person']['password_salt'] = $salt;
					}else{
						$this->message = "Your password could not be changed, please contact the administrator.";		
					}
				}
			}
			catch(Exception $e){
				$this->message = $e->getMessage();
			}
		}

		if (empty($this->message)) {									
			try
			{
				$this->user_info->save();
				$dynProf = new DynamicProfile($this->user_info);
				$dynProf->processPOST('basic');
				$dynProf->save('basic', GENERAL);
				$this->message = __('Profile updated successfully.');
				//        $this->redirect2 = PA_ROUTE_EDIT_PROFILE;
				//        $this->queryString = '?type='.$this->profile_type;


				//TODO: change URL after the contributions activity stream URLs have been changed
				$url = CC_APPLICATION_URL . CC_APPLICATION_URL_TO_API . $this->user_info->user_id;

				// Try to send updated data to Core (Ruby)
				$this->sendUserDataToCivicCommons($url ,$apiDataArray);

				$this->isError = FALSE;
			} catch (PAException $e) {
				$this->message = $e->message;
			}
		}
		$error_msg = $this->message;
	}

	public function handleDeleteUserPic($request_data) {

		/* Parag Jagdale - 10-31-10: Modified to clear extra picture urls as well as picture */
		// First delete objects from amazon s3 bucket, then clear the database
		// TODO: make this asynchronous later

		$objectToDelete = null;
		$objectFileName = null;

		if(isset($this->user_info->picture) && !empty($this->user_info->picture)){
			$objectToDelete = $this->user_info->picture;
		}else if(isset($this->user_info->avatar) && !empty($this->user_info->avatar)){
			$objectToDelete = $this->user_info->avatar;
		}else if(isset($this->user_info->avatar_small) && !empty($this->user_info->avatar_small)){
			$objectToDelete = $this->user_info->avatar_small;
		}

		if(isset($objectToDelete)){
			$objectFileName = basename($objectToDelete);
		}

		if(isset($objectFileName)){
			$this->removeAmazonS3Object($this->user_info->core_id, $objectFileName);
		}
		$this->user_info->api_call = true;
		$this->user_info->picture = NULL;
		$this->user_info->picture_dimensions = User::image_dimensions_to_array(0, 0);
		$this->user_info->avatar = NULL;
		$this->user_info->avatar_dimensions = User::image_dimensions_to_array(0, 0);
		$this->user_info->avatar_small = NULL;
		$this->user_info->avatar_small_dimensions = User::image_dimensions_to_array(0, 0);
		$this->user_info->save();
		//        $this->message = 16019;
		//        $this->redirect2 = PA_ROUTE_EDIT_PROFILE;
		//        $this->queryString = '?type='.$this->profile_type;
		$this->isError = FALSE;
		//        $this->setWebPageMessage();
	}

	/** !!
	 * Takes the HTML generated by {@see generate_inner_html()} and passes it for display.
	 *
	 * @return string HTML content to display.
	 */
	function render() {
		//Added just keeping this module backward compatible. Can be removed when this will come via dynamic page generator.
		if (!empty($_GET['type']) && in_array($_GET['type'], $this->valid_profile_types)) {
			$this->profile_type = $_GET['type'];
		}
		$this->inner_HTML = $this->generate_inner_html();
		$content = parent::render();
		return $content;
	}
	/** !!
	 * Parses the template to generate the HTML.
	 *
	 * @return string HTML.
	 */
	function generate_inner_html () {
		switch ( $this->mode ) {
			default:
				$inner_template = PA::$blockmodule_path .'/'. get_class($this) . '/center_inner_private.tpl';
		}

		$info = new Template($inner_template);

		// This lets us know what has just been POSTed, if anything.
		// e.g.: if $post_profile_type == 'basic', 'apply changes' has
		// just been clicked on the basic profile tab.
		$info->set('post_profile_type', (!isset($_POST['submit'])) ? NULL : $_POST['profile_type']);
		$info->set_object('uid', $this->uid);
		@$info->set('array_of_errors', $this->array_of_errors);
		@$info->set('user_data', $this->user_data);
		@$info->set('user_personal_data', $this->user_personal_data);
		@$info->set('user_professional_data', $this->user_professional_data);
		$info->set('blogsetting_status', $this->blogsetting_status);

		$info->set('type', $this->profile_type);
		$info->set('profile_type', $this->profile_type);
		$info->set('section_info', $this->section_info);
		$info->set_object('user_info', $this->user_info);
		$info->set('request_data', $this->request_data);
		$inner_html = $info->fetch();

		return $inner_html;
	}

	/**
	 * Creates an Amazon S3 URL for storing avatar images
	 * @TODO: make the function more generic and move to a separate class
	 * @param string $bucket_name
	 * @param string $image_size_type
	 * @param integer $user_id
	 * @param string $file_name
	 * @return string
	 */
	function buildAmazonS3ObjectURL($bucket_name, $image_size_type, $user_id, $file_name){
		if(isset($file_name) && !empty($file_name)){
			$file_name = preg_replace("/[^a-z0-9_\-\.]/i","",$file_name);
		}else{
			$file_name = intval(rand());
		}
		// TODO: make this more generic. Instead of hardcoding "avatars" directory,
		// make a object_type array and constants to determine folder structure from configuration options
		return $bucket_name . "/avatars/". $user_id . "/" . $image_size_type . "/" . $file_name;
	}


	/**
	 * Removes the object specified by the file name and user id
	 * @param unknown_type $user_id
	 * @param unknown_type $file_name
	 * @return boolean
	 */
	private function removeAmazonS3Object($user_id, $file_name){
		// TODO: make this asynchronous later

		global $app;
		$objectURL = null;
		$aws_key = null;
		$aws_secret_key = null;
		$aws_key = $app->configData['configuration']['api_keys']['value']['amazon_aws_key']['value'];
		$aws_secret_key = $app->configData['configuration']['api_keys']['value']['amazon_aws_secret']['value'];

		if(isset($aws_key) && isset($aws_secret_key)){
			$s3 = null;
			$bucketAvailable = false;
			$s3 = new Zend_Service_Amazon_S3($aws_key, $aws_secret_key);
			$bucketAvailable = $s3->isBucketAvailable(AMAZON_BUCKET_NAME);

			if($bucketAvailable){
				// bucket is available so try to delete the object
				try{

					foreach($this->_image_sizes as $imageSizeType => $imageDimensions){
						$objectPath = $this->buildAmazonS3ObjectURL(AMAZON_BUCKET_NAME, $imageSizeType, $user_id, $file_name);
						$s3->removeObject($objectPath);
					}
					return true;
				}
				catch(Exception $e){
					// ignore this error - the extra amazons3 object in the bucket
					// will not harm anything. It will just be an unclean directory
					// take care of cleaning asynchronously by deleting orphan objects
					// that do not appear in the user's picture/avatar urls
					//$this->message = $e->getMessage();
				}
			}else{
				// no bucket is available
				return false;
			}
		}
		return false;
	}

	/**
	 * Creates a REST API call to CivicCommons API to modify the user data
	 * TODO: Move this to a CivicCommons specific file
	 */
	private function sendUserDataToCivicCommons($URL, $DataArray){
		$jsonString = null;
		if(!isset($URL) || !empty($url)){
			return false;
		}

		if(count($DataArray['person']) == 0){
			return false;
		}

		$jsonString = json_encode($DataArray);

		try{
			$request = new CurlRequestCreator($URL, true, 30, 4, false, true, false);
			$request->setPut($jsonString);
			$request->setContentType("Content-type: application/json");

			$responseStatus = $request->createCurl();
			if($responseStatus == 200){
				return true;
			}else{
				Logger::log('sendUserDataToCivicCommons() could not PUT data to ' . $URL . ' Returned with: ' . $request->getResponseHeader(), LOGGER_WARNING);
				return false;
			}
		}
		catch(Exception $ex){

			Logger::log('sendUserDataToCivicCommons() could not PUT data to ' . $URL . ' Exception: ' . $ex->getMessage(), LOGGER_WARNING);

		}
	}


	/**
	 * Returns an encrypted password and the salt used to encrypt the password
	 * @param unknown_type $PasswordToEncrypt
	 */
	function EncryptPassword($PasswordToEncrypt){

		global $app;
		if(!isset($PasswordToEncrypt) || empty($PasswordToEncrypt)){
			return null;
		}

		if (CRYPT_BLOWFISH == 1) {
			$encryptedPassword = null;
			$salt = null;

			$pepper = PASSWORD_PEPPER;
			$cost = PASSWORD_COST;

			// 1. Generate a random pre-salt with OpenSSL Random
			$preSalt = bin2hex(openssl_random_pseudo_bytes(21));
				
			if(isset($preSalt) && !empty($preSalt)){

				// 2. use salt and pepper to create password
				$salt = substr($preSalt, 0, 22);
				$salt = '$2a$'.$cost.'$'.$salt . '$';
				$encryptedPassword = crypt($PasswordToEncrypt.$pepper, $salt);

				// 3. return encrypted password and salt
				return array($encryptedPassword, $salt);
			}else{
				return null;
			}
		}else{
			return null;
		}
	}

}
?>
