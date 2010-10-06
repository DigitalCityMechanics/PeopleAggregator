<?php
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
    "^/home$"  => "http://stagining.theciviccommons.com",
  );
  
  
// Civic Commons Application URL
define('CC_APPLICATION_URL', 'http://staging.theciviccommons.com');
define('CC_ROUTE_HOME_PAGE', '/');
define('CC_ROUTE_CONVERSATIONS', '/conversations');
define('CC_ROUTE_ISSUES', '/issues');
define('CC_ROUTE_ABOUT', '/about');
?>
