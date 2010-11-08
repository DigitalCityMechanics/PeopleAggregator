<?php

// Civic Commons Application URL
define('CC_APPLICATION_URL', 		'http://staging.theciviccommons.com');
define('CC_APPLICATION_URL_TO_API', '/api');
define('CC_ROUTE_HOME_PAGE', 		'/');
define('CC_ROUTE_CONVERSATIONS', 	'/conversations');
define('CC_ROUTE_CONTRIBUTIONS', 	'/contributions');
define('CC_ROUTE_THOUGHTS', 		'/thoughts');
define('CC_ROUTE_FOLLOWING', 		'/subscriptions');
define('CC_ROUTE_PEOPLE', 			'/people');
define('CC_ROUTE_ORGANIZATIONS', 	'/organizations');
define('CC_ROUTE_ISSUES', 			'/issues');
define('CC_ROUTE_ABOUT', 			'/about');
define('CC_IN_THE_NEWS_CONTENT_ID',	6);

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
	"^/press(.*)$" => "/in-the-news.php?cid=".CC_IN_THE_NEWS_CONTENT_ID,
	"^/in-the-news(.*)$" => "/in-the-news.php?cid=".CC_IN_THE_NEWS_CONTENT_ID,
  );
  
?>
