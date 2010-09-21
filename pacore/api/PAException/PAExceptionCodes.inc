<?php
include_once dirname(__FILE__) . "/../../ext/HttpStatusCodes.php";

/** $pa_error_name_mapping is used to map exceptions to API responses
 * - for the external (web services) API.
 */
$pa_error_name_mapping = array();

/**
 * Define an error code using define() and also stash a copy of it in
 * $pa_error_name_mapping so we can look it up if an exception occurs
 * 
 * @param $name		name of the error
 * @param $value	error code of the error
 * @param $httpStatusCode	HTTP status code for the error
 */
function define_err($name, $value, $httpStatusCode) {
  global $pa_error_name_mapping;
  $pa_error_name_mapping[$value] = array(strtolower($name), $httpStatusCode);
  define($name, $value);
}
/** translate an error code (e.g. GENERAL_SOME_ERROR) into an error
 * string suitable for returning in an API call response
 * (e.g. "general_some_error") */
function pa_get_error_name($code) {
  global $pa_error_name_mapping;
  list($code_string, $httpStatusCode) = $pa_error_name_mapping[$code];
  
  if ($code_string === NULL){
    return "<Invalid error code: $code>";
  }
  return array($code_string, $httpStatusCode);
}

/**
 * General Exception Codes
 * Range: 1 to 99
 * Prefix: GENERAL_
 */
define_err("GENERAL_SOME_ERROR", 1, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
define_err("ROLE_ID_NOT_EXIST", 2, HttpStatusCodes::HTTP_NOT_FOUND);
define_err("AUTHOR_NAME_NOT_PRESENT", 3, HttpStatusCodes::HTTP_PRECONDITION_FAILED);
define_err("AUTHOR_EMAIL_NOT_PRESENT", 4, HttpStatusCodes::HTTP_PRECONDITION_FAILED);
define_err("AUTHOR_HOMEPAGE_NOT_PRESENT", 5, HttpStatusCodes::HTTP_PRECONDITION_FAILED);
define_err("ROW_DOES_NOT_EXIST", 6, HttpStatusCodes::HTTP_NOT_FOUND);
define_err("BLOG_NOT_EXIST", 7, HttpStatusCodes::HTTP_NOT_FOUND);
define_err("INVALID_INVITATION_ID", 8, HttpStatusCodes::HTTP_PRECONDITION_FAILED);
define_err("MAIL_FUNCTION_FAILED",9, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
define_err("OPERATION_NOT_PERMITTED", 10, HttpStatusCodes::HTTP_UNAUTHORIZED);
define_err("RELATION_ALREADY_EXISTS", 11, HttpStatusCodes::HTTP_CONFLICT);
define_err("COOKIE_FAILED", 12, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
define_err("TAG_NOT_EXIST", 13, HttpStatusCodes::HTTP_NOT_FOUND);
define_err("FILE_NOT_UPLOADED", 14, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
define_err("INVALID_INVITATION_EMAIL", 15, HttpStatusCodes::HTTP_PRECONDITION_FAILED);
define_err("INVALID_MESSAGE", 16, HttpStatusCodes::HTTP_NOT_FOUND);
define_err("INVALID_FORGOT_PASSWORD_ID", 17, HttpStatusCodes::HTTP_NOT_FOUND);
define_err("RELATION_NOT_EXIST", 18, HttpStatusCodes::HTTP_NOT_FOUND);
define_err("INVALID_RELATION", 19, HttpStatusCodes::HTTP_NOT_FOUND);
define_err("REMOTE_ERROR", 20, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR); // error returned from remote service - e.g. flickr
define_err("VALIDATION_INCORRECT_TYPE", 21, HttpStatusCodes::HTTP_BAD_REQUEST); // api call validation error
define_err("USER_ACCESS_DENIED", 22, HttpStatusCodes::HTTP_UNAUTHORIZED); // attempt to access or post to a collection you don't have access to
define_err("MISSING_DEPENDENCY", 23, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR); // missing something like GD or imagemagick
define_err("FILE_NOT_FOUND", 24, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
define_err("INVALID_ID", 25, HttpStatusCodes::HTTP_NOT_FOUND); // invalid id passed to an api function (i.e. "asdf:123" instead of "group:123")
define_err("BAD_PARAMETER", 26, HttpStatusCodes::HTTP_BAD_REQUEST);
define_err("ITEM_ALREADY_EXISTS", 28, HttpStatusCodes::HTTP_CONFLICT); // used by badge - if you try to rename a badge to have the same name as an existing badge
define_err("IMPORT_URL_ALREADY_EXISTS", 29, HttpStatusCodes::HTTP_CONFLICT);
define_err("IMPORT_FAILED", 30, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
define_err("STORAGE_ERROR", 31, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR); // error from storage system
define_err("NON_MEMBER_ACCESS_TO_NETWORK", 32, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
define_err("INVALID_FILE", 33, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR); // attempted to upload file of the wrong type, or failed to sniff file type
/**
 * Database Exception Codes
 * Range: 100 to 199
 * Prefix: DB_
 */
define_err("DB_QUERY_FAILED", 100, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
define_err("DB_CONNECTION_FAILED", 101, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
define_err("RECORD_DOES_NOT_EXIST", 102, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
define_err("DUPLICATED_RECORD_FOUND", 103, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);

/**
 * Content Related Exception Codes
 * Range: 200 to 299
 * Prefix: CONTENT_
 */
 define_err("CONTENT_NOT_FOUND", 200, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("CONTENT_COLLECTION_NOT_FOUND", 201, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("COMMENT_NOT_EXIST", 202, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("CONTENT_HAS_BEEN_DELETED",203, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("CONTENT_COLLECTION_TITLE_ALREADY_EXIST", 205, HttpStatusCodes::HTTP_CONFLICT);
 define_err("CONTENT_INVALID", 206, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("CONTENT_NOT_AUTHORISED_TO_ACCESS", 207, HttpStatusCodes::HTTP_UNAUTHORIZED);

 /**
 * User Related Exception Codes
 * Range: 300 to 399
 * Prefix: USER_
 */
 define_err("USER_NOT_FOUND", 300, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("USER_INVALID_LOGIN_NAME", 301, HttpStatusCodes::HTTP_UNAUTHORIZED);
 define_err("PASSWORD_NOT_EXIST", 302, HttpStatusCodes::HTTP_UNAUTHORIZED);
 define_err("SAVING_DELETED_USER", 303, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("USER_LOGINNAME_TAKEN", 304, HttpStatusCodes::HTTP_PRECONDITION_FAILED);
 define_err("USER_ALREADY_DELETED", 305, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("USER_INVALID_PASSWORD", 306, HttpStatusCodes::HTTP_UNAUTHORIZED);
 define_err("USER_INVALID_NAME", 307, HttpStatusCodes::HTTP_UNAUTHORIZED);
 define_err("USER_INVALID_EMAIL", 308, HttpStatusCodes::HTTP_UNAUTHORIZED);
 define_err("USER_INVALID", 309, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("USER_TOKEN_EXPIRED", 310, HttpStatusCodes::HTTP_UNAUTHORIZED);
 define_err("USER_TOKEN_INVALID", 311, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("SAVING_UNVERIFIED_USER", 312, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
 define_err("USER_EMAIL_NOT_UNIQUE", 313, HttpStatusCodes::HTTP_PRECONDITION_FAILED);


/**
 * Type Related Exception Codes
 * Range: 400 to 499
 * Prefix: TYPE_
 */
 define_err("TYPE_NOT_AN_ARRAY", 400, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);





 /** General required variable missing Exception Codes
 * Range: 500 to 599
 * Prefix: REQUIRED_
 */

 define_err("REQUIRED_PARAMETERS_MISSING", 500, HttpStatusCodes::HTTP_PRECONDITION_FAILED);

/**
 * Event Related Exception Codes
 * Range: 600 to 699
 * Prefix: EVENT_
 */
 define_err("EVENT_ORGANIZER_NOT_EXIST",600, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("EVENT_VENUE_NOT_EXIST",601, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("EVENT_START_TIME_NOT_EXIST",602, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("EVENT_END_TIME_NOT_EXIST",603, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("EVENT_START_DATE_NOT_EXIST",604, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("EVENT_END_DATE_NOT_EXIST",605, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("EVENT_DESCRIPTION_NOT_EXIST",606, HttpStatusCodes::HTTP_NOT_FOUND);

 // added by Martin for the Event class
 // starting from 620 to not conflict with pervious definitions
 define_err("EVENT_NOT_EXIST",620, HttpStatusCodes::HTTP_NOT_FOUND);

/**
 * Review Related Exception Codes
 * Range: 700 to 799
 * Prefix: REVIEW_
 */
 define_err("REVIEW_NAME_NOT_EXIST",700, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("REVIEW_TYPE_NOT_EXIST",701, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("REVIEW_RATING_NOT_EXIST",702, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("REVIEW_DESCRIPTION_NOT_EXIST",704, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("REVIEW_SUMMARY_NOT_EXIST",705, HttpStatusCodes::HTTP_NOT_FOUND);

/**
 * Group Related Exception Codes
 * Range: 800 to 899
 * Prefix: GROUP_
 */
 define_err("GROUP_NAME_NOT_EXIST",800, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("GROUP_ACCESS_TYPE_NOT_EXIST",801, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("GROUP_REGISTRATION_TYPE_NOT_EXIST",802, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("GROUP_IS_MODERATED_NOT_EXIST",803, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("GROUP_DESCRIPTION_NOT_EXIST",804, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("GROUP_PARAMETER_ERROR",805, HttpStatusCodes::HTTP_PRECONDITION_FAILED);
 define_err("GROUP_CREATION_FAILED",806, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
 define_err("GROUP_NOT_INVITED", 807, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
 define_err("INVALID_INV", 808, HttpStatusCodes::HTTP_NOT_FOUND);

 // attempt to join an invite-only group without an invitation


 /**
 * MESSAGEBOARD  && CATEGORY Related Exception Codes
 * Range: 900 to 1000
 * Prefix: GROUP_
 */
 define_err("CATEGORY_DOES_NOT_EXIST",900, HttpStatusCodes::HTTP_NOT_FOUND);

  /**
 * NETWORK Related Exception Codes
 * Range: 1000 to 1100
 * Prefix: NETWORK_
 */
 define_err("NETWORK_ALREADY_EXISTS",1000, HttpStatusCodes::HTTP_CONFLICT);
 define_err("NETWORK_DIRECTORY_PERMISSION_ERROR",1001, HttpStatusCodes::HTTP_UNAUTHORIZED);
 define_err("NETWORK_MYSQL_FILE",1002, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
 define_err("NETWORK_NOT_FOUND",1003, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("NETWORK_INVALID_STEP",1004, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
 define_err("NETWORK_INTERNAL_ERROR",1005, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);

 //configurations errors
 define_err("MOTHER_NETWORK_NOT_DEFINED",1006, HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);

 define_err("INVALID_ARGUMENTS",1007, HttpStatusCodes::HTTP_PRECONDITION_FAILED);

 /**
 * ITEM error codes.
 **/
 define_err("ITEM_NOT_FOUND",1101, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("ITEM_COLLECTION_NOT_LOADED",1102, HttpStatusCodes::HTTP_NOT_FOUND);
 define_err("ITEM_CONTENT_NOT_LOADED",1103, HttpStatusCodes::HTTP_NOT_FOUND);
?>
