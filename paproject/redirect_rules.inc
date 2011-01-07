<?php

// Civic Commons Application URL
define('CC_APPLICATION_URL_TO_API', '/api/people-aggregator/person/');
define('CC_ROUTE_HOME_PAGE', 		'/');
define('CC_ROUTE_CONVERSATIONS', 	'/conversations');
define('CC_ROUTE_CONTRIBUTIONS', 	'/contributions');
define('CC_ROUTE_THOUGHTS', 		'/thoughts');
define('CC_ROUTE_FOLLOWING', 		'/subscriptions');
define('CC_ROUTE_PEOPLE', 			'/people');
define('CC_ROUTE_ORGANIZATIONS', 	'/organizations');
define('CC_ROUTE_ISSUES', 			'/issues');
define('CC_ROUTE_ABOUT', 			'/about');

// Routing rewrites:

  $project_routes = array (

    /**
    *
    *  /api -> /api/doc/index.php
    *
    **/
    "^/api[\/]?$"  => "/api/doc/index.php",

    /**
    *
    *  / -> /index.php
    *
    **/
    "^/$"  => "/index.php",
  
    /**
    *
    *  / -> /index.php
    *
    **/
    "^/home$"  => "http://staging.theciviccommons.com",
  
    /**
    *
    *  / -> /organizations
    *
    **/
    "^/organizations$"  => "/dynamic.php?page_id=300",

    /**
    *
    *  /directory/someType -> dynamic.php?page_id=300&type=someType
    *
    **/
    "^/organizations/(\w*)$" => "/dynamic.php?page_id=300&type=%s",

	/**
 	*
 	*  /blog/ -> dynamic.php?page_id=5
 	*
 	**/
	"^/blog[\/\?]?(.*)$" => "/dynamic.php?page_id=5&%s",

	/**
 	*
 	*  /in-the-news/ -> in-the-news.php?cid=".CC_IN_THE_NEWS_CONTENT_ID
 	*
 	**/
	"^/press(.*)$" => "/in-the-news.php?cid=".$app->configData['configuration']['civic_commons_settings']['value']['CC_IN_THE_NEWS_CONTENT_ID']['value'],
	"^/in-the-news(.*)$" => "/in-the-news.php?cid=".$app->configData['configuration']['civic_commons_settings']['value']['CC_IN_THE_NEWS_CONTENT_ID']['value'],
  
    /**
    *
    *  /forgotPassword -> externalRedirect.php?url=*
    *
    *
    **/
    "^/forgotPassword[\/]?(.*)$" => "/externalRedirect.php?url=people/secret/new",
    
    /**
    *
    *  /login.php -> externalRedirect.php?url=*
    *
    *
    **/
    "^/login[\/]?(.*)$" => "/externalRedirect.php?url=people/login"
  );
  
?>
